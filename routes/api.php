<?php

use App\Http\Controllers\api\v1\auth\AuthController;
use App\Http\Controllers\api\v1\category\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\post\PostController;

Route::prefix('v1')->middleware('auth:api')->group(function () {
    Route::resource('posts', PostController::class);
    Route::resource('categories', CategoryController::class);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
