<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function userNotification()
    {
        return \response()->json(auth()->user()->unreadNotification(),Response::HTTP_OK);

    }


}
