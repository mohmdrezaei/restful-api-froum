<?php

use App\Http\Controllers\Api\V1\Thread\AnswerController;
use App\Http\Controllers\Api\V1\Thread\ThreadController;
use Illuminate\Support\Facades\Route;

Route::resource('threads' , ThreadController::class);

Route::prefix('/threads')->group(function (){
    Route::resource('answers' , AnswerController::class);
});
