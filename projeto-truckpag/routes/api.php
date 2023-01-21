<?php

use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, 'returnStatus']);

Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'getAllProducts']);
    Route::put('/{code}', [ProductController::class, 'update']);
    Route::delete('/{code}', [ProductController::class, 'delete']);
    Route::get('/{code}', [ProductController::class, 'getProductByCode']);
});
