<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Channel\ChannelController;

Route::prefix('/channel')->group(function (){
    Route::get('/all',[ChannelController::class , 'getAllChannelsList'])->name('channel.all');
    Route::middleware(['can:channel management','auth:sanctum'])->group(function (){
        Route::post('/store',[ChannelController::class , 'createNewChannel'])->name('channel.store');
        Route::put('/update',[ChannelController::class , 'updateChannel'])->name('channel.update');
        Route::delete('/delete',[ChannelController::class , 'destroyChannel'])->name('channel.delete');
    });

});
