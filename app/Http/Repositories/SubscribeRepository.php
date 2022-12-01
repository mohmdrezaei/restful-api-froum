<?php

namespace App\Http\Repositories;

use App\Models\Answer;
use App\Models\Subscribe;
use App\Models\Thread;
use Illuminate\Http\Request;

class SubscribeRepository
{
    public function getNotifiableUsers($thread_id)
    {
        return Subscribe::query()->where('thread_id' ,$thread_id)->pluck('user_id')->all();
    }

}
