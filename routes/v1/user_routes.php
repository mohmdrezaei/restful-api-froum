<?php

use App\Http\Controllers\Api\V1\User\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('/auth')->group(function (){
    Route::get('/user',[UserController::class,'leaderboards'])->name('auth.user');
});
