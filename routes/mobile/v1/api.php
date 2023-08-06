<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Mobile\api\v1\auth\AuthController;
use App\Http\Controllers\Mobile\api\v1\post\PostController;
use App\Http\Controllers\Mobile\api\v1\category\CategoryController;
use App\Http\Controllers\Mobile\api\v1\fcm\FCMController;

Route::middleware('auth:api')->group(function () {
    // Post Management
    Route::apiResource('posts', PostController::class);
    // Category Management
    Route::apiResource('categories', CategoryController::class);
    // FCM Management
    Route::post('save-token', [FCMController::class, 'saveToken'])->name('fcm.save_token');
    Route::post('send-notification', [FCMController::class, 'sentNotification'])->name('fcm.send_notification');
});

// Authentication Management
Route::post('request_otp', [AuthController::class, 'requestOtp'])->name('auth.request_otp');
Route::post('verify_otp', [AuthController::class, 'verfiyOtp'])->name('auth.verify_otp');
Route::post('register', [AuthController::class, 'register'])->name('auth.register');
Route::post('login', [AuthController::class, 'login'])->name('auth.login');
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('auth.logout');
Route::post('change_password', [AuthController::class, 'changePassword'])->middleware('auth:api')->name('auth.change_password');
Route::post('forgot_password_request_otp', [AuthController::class, 'forgotPasswordRequestOtp'])->name('auth.forgot_password_request_otp');
Route::post('forgot_password_verify', [AuthController::class, 'forgotPasswordVerify'])->name('auth.forgot_password_verify');
Route::post('forgot_password_change_password', [AuthController::class, 'forgotPasswordChangePassword'])->name('auth.forgot_password_change_password');
