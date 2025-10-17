<?php

namespace App\Http\Controllers;

use App\Models\ProductImport;
use App\Models\ProductMasterList;
use Illuminate\Http\Request;
use App\Services\ProductServices;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductServices $productService)
    {
        $this->productService = $productService;
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,csv'
        ]);

        $this->productService->processUpload($request->file('file'));

        return response()->json(['message' => 'File uploaded and queued for processing']);
    }

    public function listProduct()
    {
        $data = $this->productService->getData();

        return response()->json($data);
    }

    public function listProductIds()
    {
        $data = $this->productService->getProductIds();

        return response()->json($data);
    }
}
