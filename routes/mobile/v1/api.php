<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Mobile\api\v1\auth\AuthController;

// Authentication Management
Route::post('register', [AuthController::class, 'register'])->name('auth.register');
Route::post('login', [AuthController::class, 'login'])->name('auth.login');
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('auth.logout');
Route::post('change_password', [AuthController::class, 'changePassword'])->middleware('auth:api')->name('auth.change_password');
