<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Repositories\UserRepository;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function userNotification()
    {
        return \response()->json(auth()->user()->unreadNotification(),Response::HTTP_OK);

    }

    public function leaderboards()
    {
        return resolve(UserRepository::class)->leaderboards();
    }


}
