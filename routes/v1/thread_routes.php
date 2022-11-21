<?php

use App\Http\Controllers\Api\V1\Thread\ThreadController;
use Illuminate\Support\Facades\Route;

Route::resource('threads' , ThreadController::class);

