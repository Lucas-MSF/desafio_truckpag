<?php

use App\Http\Controllers\DBController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DBController::class, 'returnStatus']);
Route::prefix('products')->group(function () {
    Route::post('/', [ProductController::class, 'store']);
    Route::get('/', [ProductController::class, 'getAllProducts']);
    Route::put('/{code}', [ProductController::class, 'update']);
    Route::delete('/{code}', [ProductController::class, 'delete']);
    Route::get('/{code}', [ProductController::class, 'getProductByCode']);
});
