<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProductController;
use PhpOffice\PhpSpreadsheet\IOFactory;

Route::get('/ping', function () {
    return response()->json(['message' => 'API is working!']);
});

// ✅ Auth routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/test-spreadsheet', function () {
    return storage_path('app/private/');
});

// check session
Route::get('/check-session', function () {
    return response()->json([
        'loggedIn' => auth()->check()
    ]);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // upload product
    Route::post('/products/upload', [ProductController::class, 'upload']);

    // list product
    Route::get('/product/list', [ProductController::class, 'listProduct']);

    // product ids
    Route::get('/product/product-id', [ProductController::class, 'listProductIds']);
});
