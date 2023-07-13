<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\api\v1\auth\AuthController;
use App\Http\Controllers\Admin\api\v1\post\PostController;
use App\Http\Controllers\Admin\api\v1\role\RoleController;
use App\Http\Controllers\Admin\api\v1\user\UserController;
use App\Http\Controllers\Admin\api\v1\category\CategoryController;
use App\Http\Controllers\Admin\api\v1\permission\PermissionController;

Route::middleware('auth:api')->group(function () {
    // Post Management
    Route::apiResource('posts', PostController::class);
    // Category Management
    Route::apiResource('categories', CategoryController::class);
    // Role & Psermssions Management
    Route::apiResource('roles', RoleController::class);
    Route::apiResource('permissions', PermissionController::class)->except(['destroy']);
    // User Management
    Route::apiResource('user', UserController::class);
    Route::delete('force_delete/{id}', [UserController::class, 'userForceDelete'])->name('user.force_delete');
    Route::post('return_reject/{id}', [UserController::class, 'userReturnReject'])->name('user.return_reject');
});

// Authentication Management
Route::post('register', [AuthController::class, 'register'])->name('auth.register');
Route::post('login', [AuthController::class, 'login'])->name('auth.login');
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('auth.logout');
Route::post('change_password', [AuthController::class, 'changePassword'])->middleware('auth:api')->name('auth.change_password');
