<?php

namespace App\Http\Repositories;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    /**
     * @param Request $request
     * @return void
     */
    public function create(Request $request): void
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
    }
}
