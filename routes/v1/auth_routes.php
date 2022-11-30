<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Auth\UserController;

Route::prefix('/auth')->group(function (){
    Route::post('/register',[UserController::class,'register'])->name('auth.register');
    Route::post('/login',[UserController::class,'login'])->name('auth.login');
    Route::get('/user',[UserController::class,'user'])->name('auth.user');
    Route::post('/logout',[UserController::class,'logout'])->name('auth.logout');
});
