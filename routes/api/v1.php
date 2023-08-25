<?php

use App\Http\Controllers\Api\v1\ProductController;
use App\Http\Controllers\api\v1\User\AuthController;
use Illuminate\Support\Facades\Route;

// user routes
Route::prefix('user')->group(function () {
    // auth routes
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('/', [AuthController::class, 'profile']);
});


// product routes
Route::get('products', [ProductController::class, 'index']);
Route::post('product/create', [ProductController::class, 'create']);
Route::get('product/{product:uuid}', [ProductController::class, 'show']);
Route::put('product/{product:uuid}', [ProductController::class, 'update']);
Route::delete('product/{product:uuid}', [ProductController::class, 'destroy']);
