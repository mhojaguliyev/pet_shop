<?php

use App\Http\Controllers\api\v1\User\AuthController;
use Illuminate\Support\Facades\Route;

// user routes
Route::prefix('user')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
});
