<?php

namespace App\Http\Repositories;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    public function find($id)
    {
        User::find($id);
    }
    /**
     * @param Request $request
     * @return User
     */
    public function create(Request $request): User
    {
       return User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
    }

    public function leaderboards()
    {
       return User::query()->orderByDesc('score')->paginate();
    }

    public function isBlock() :bool
    {
        return (bool) auth()->user()->is_block;
    }
}
