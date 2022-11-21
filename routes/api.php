<?php

use App\Http\Controllers\Api\V1\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    // auth routes
    include __DIR__ . '\v1\auth_routes.php';

    //channel routes
    include __DIR__ . '\v1\channel_routes.php';

    //thread routes
    include __DIR__ . '\v1\thread_routes.php';

});
