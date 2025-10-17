<?php

namespace App\Services;

use App\Jobs\ProcessProductImport;
use App\Models\Product;
use App\Models\ProductImport;
use App\Models\ProductMasterList;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductServices
{
    public function processUpload($file)
    {
        // store file
        $path = $file->store('uploads', 'public');

        // $fullPath =         public_path('storage/' . $path);
        // dd($fullPath);
        ProcessProductImport::dispatch($path);
    }

    public function getData()
    {
        $productId = $_GET['product_id'] ?? null;

        $query = ProductMasterList::query();
        if ($productId) {
            $data = $query->where('product_id', $productId);
        }

        $data = $query->paginate(2);

        return $data;
    }

    public function getProductIds()
    {
        $data = ProductMasterList::select('product_id')->groupBy('product_id')->get();

        return $data;
    }
}
