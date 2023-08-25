<?php

use Illuminate\Support\Facades\Route;

// api v1
Route::prefix('v1')->group(function () {
    require __DIR__ .'/api/v1.php';
});
