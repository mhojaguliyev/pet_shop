<?php

use App\Http\Controllers\Api\v1\CategoryController;
use App\Http\Controllers\Api\v1\ProductController;
use App\Http\Controllers\Api\v1\User\AuthController as UserAuthController;
use Illuminate\Support\Facades\Route;

Route::group(['as' => 'api.'], function () {
    // auth routes
    Route::post('user/login', [UserAuthController::class, 'login']);
    Route::post('user/logout', [UserAuthController::class, 'logout']);

    // user routes
    Route::get('user', [UserAuthController::class, 'profile']);

    // category routes
    Route::get('categories', [CategoryController::class, 'index']);

    // product routes
    Route::get('products', [ProductController::class, 'index']);
    Route::post('product/create', [ProductController::class, 'create']);
    Route::get('product/{product:uuid}', [ProductController::class, 'show']);
    Route::put('product/{product:uuid}', [ProductController::class, 'update']);
    Route::delete('product/{product:uuid}', [ProductController::class, 'destroy']);
});
