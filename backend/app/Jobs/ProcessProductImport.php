<?php

namespace App\Jobs;

use App\Models\Product;
use App\Models\ProductImport;
use App\Models\ProductMasterList;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ProcessProductImport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $path;
    protected $import;

    public function __construct($path)
    {
        $this->path = $path;
    }

    public function handle(): void
    {

        try {
            $fullPath = public_path('storage/' . $this->path);
            $spreadsheet = IOFactory::load($fullPath);
            $rows = $spreadsheet->getActiveSheet()->toArray();

            $updateData = [];

            foreach (array_slice($rows, 1) as $row) {
                $productId = $row[0] ?? null;
                $status    = strtolower($row[5] ?? ''); // convert ke lowercase

                if (!$productId || !in_array($status, ['sold', 'buy'])) {
                    continue; // skip row invalid
                }

                if (!isset($updateData[$productId])) {
                    $updateData[$productId] = ['buy' => 0, 'sold' => 0];
                }

                if ($status === 'sold') {
                    $updateData[$productId]['sold'] += 1;
                } elseif ($status === 'buy') {
                    $updateData[$productId]['buy'] += 1;
                }
            }

            foreach ($updateData as $productId => $data) {
                $product = ProductMasterList::where('product_id', $productId)->first();
                if ($product) {
                    $product->quantity = $product->quantity + $data['buy'] - $data['sold'];
                    $product->save();
                }
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
