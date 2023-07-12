<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\api\v1\auth\AuthController;
use App\Http\Controllers\Admin\api\v1\post\PostController;
use App\Http\Controllers\Admin\api\v1\role\RoleController;
use App\Http\Controllers\Admin\api\v1\user\UserController;
use App\Http\Controllers\Admin\api\v1\category\CategoryController;
use App\Http\Controllers\Admin\api\v1\permission\PermissionController;

Route::middleware('auth:api')->group(function () {
    Route::apiResource('posts', PostController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('roles', RoleController::class);
    Route::apiResource('permissions', PermissionController::class)->except(['destroy']);
    Route::apiResource('user', UserController::class);
});

// Authentication
Route::post('register', [AuthController::class, 'register'])->name('auth.register');
Route::post('login', [AuthController::class, 'login'])->name('auth.login');
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('auth.logout');
Route::post('change_password', [AuthController::class, 'changePassword'])->middleware('auth:api')->name('auth.change_password');
