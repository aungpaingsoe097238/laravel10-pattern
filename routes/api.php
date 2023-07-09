<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\api\v1\auth\AuthController;
use App\Http\Controllers\Admin\api\v1\post\PostController;
use App\Http\Controllers\Admin\api\v1\role\RoleController;
use App\Http\Controllers\Admin\api\v1\category\CategoryController;
use App\Http\Controllers\Admin\api\v1\permission\PermissionController;

Route::prefix('admin/v1')->middleware('auth:api')->group(function () {
    Route::apiResource('posts', PostController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('roles', RoleController::class);
    Route::apiResource('permissions', PermissionController::class);
});

Route::prefix('admin/v1')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');
    Route::post('change_password', [AuthController::class, 'changePassword'])->middleware('auth:api');
});
