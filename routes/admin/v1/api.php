<?php

use App\Http\Controllers\Admin\api\v1\attachment\AttachmentController;
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
    // Attachment Management
    Route::apiResource('attachment', AttachmentController::class);
});

// Authentication Management
Route::post('login', [AuthController::class, 'login'])->name('auth.login');
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('auth.logout');
