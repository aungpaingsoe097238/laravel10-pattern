<?php

use App\Http\Controllers\api\v1\category\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\post\PostController;

Route::prefix('v1')->group(function(){
    Route::resource('posts', PostController::class);
    Route::resource('categories', CategoryController::class);
});
