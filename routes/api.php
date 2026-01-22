<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

Route::middleware('api')->group(function () {
    // Public Authentication Routes
    Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
    Route::post('/register', [AuthController::class, 'register'])->middleware('guest');

    // Protected Routes
    Route::middleware('auth:api')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::get('/me', [AuthController::class, 'me']);
    });
});
