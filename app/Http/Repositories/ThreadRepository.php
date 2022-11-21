<?php

namespace App\Http\Repositories;

use App\Models\Thread;

class ThreadRepository
{
    public function getAllAvailableThreads()
    {
        return Thread::whereFlag(1)->latest()->get();
   }

    public function getThreadBySlug($slug)
    {
        return Thread:: whereSlug($slug)->whereFlag(1)->get();
    }
}
