<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;


class AuthController extends Controller

// registration =>
{
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'message' => 'User Registered successfuly',
            'user' => $user
        ], 201);
    }


    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                "message" => "unvalid email or password",
            ], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            "message" => "login successfuly",
            "user" => $user,
            "token" => $token
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => "logout successfuly"
        ]);
    }
}
