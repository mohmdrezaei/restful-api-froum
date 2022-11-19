<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Repositories\UserRepository;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // validation form inputs
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required']
        ]);

        // Insert User Into Database
        $user = resolve(UserRepository::class)->create($request);
        $defaultSuperAdminEmail = config('permission.default_super_admin_email');
        $user->email === $defaultSuperAdminEmail ? $user->assignRole('Super Admin') : $user->assignRole('User');
        return response()->json([
            'message' => 'user created successfully'
        ], 201);
    }

    public function login(Request $request)
    {
        // validation form inputs
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        //check login user
        if (Auth::attempt($request->only(['email', 'password']))) {
            return response()->json([Auth::user()], 200);

            throw ValidationException::withMessages([
                'email' => 'incorrect credentials'
            ]);
        }
    }

    public function user()
    {
        return response()->json([Auth::user()], 200);
    }

    public function logout()
    {
        Auth::logout();

        return response()->json([
            'message' => 'logged out successfully'
        ], 200);
    }


}
