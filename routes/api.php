<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\auth\AuthController;
use App\Http\Controllers\api\v1\post\PostController;
use App\Http\Controllers\api\v1\role\RoleController;
use App\Http\Controllers\api\v1\category\CategoryController;
use App\Http\Controllers\api\v1\permission\PermissionController;

Route::prefix('v1')->middleware('auth:api')->group(function () {
    Route::resource('posts', PostController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::get('getRolePermission/{id}', [PermissionController::class, "getRolePermission"]); // GET role permissions with object
    Route::get('getRolePermissions/{id}', [PermissionController::class, "getRolePermissions"]); // GET role permissions with array
});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');
Route::post('change_password', [AuthController::class, 'changePassword'])->middleware('auth:api');
