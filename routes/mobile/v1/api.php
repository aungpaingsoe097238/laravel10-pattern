<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Mobile\api\v1\auth\AuthController;
use App\Http\Controllers\Mobile\api\v1\post\PostController;
use App\Http\Controllers\Mobile\api\v1\category\CategoryController;

Route::middleware('auth:api')->group(function () {
    // Post Management
    Route::apiResource('posts', PostController::class);
    // Category Management
    Route::apiResource('categories', CategoryController::class);
});

// Authentication Management
Route::post('register', [AuthController::class, 'register'])->name('auth.register');
Route::post('login', [AuthController::class, 'login'])->name('auth.login');
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('auth.logout');
Route::post('change_password', [AuthController::class, 'changePassword'])->middleware('auth:api')->name('auth.change_password');
