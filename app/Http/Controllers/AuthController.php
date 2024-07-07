<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthController extends ApiController
{

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('API token for ' . $user->email)->plainTextToken;

        return $this->ok("The account created successfully", ['token' => $token]);
    }


    public function login(LoginRequest $request)
    {
        $user = User::firstwhere('email', $request->email);

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'The Eamil or password is incorrect.'
            ], 401);
        }

        $token = $user->createToken('API token for ' . $user->email)->plainTextToken;

        return $this->ok("The account logged in successfully", ['token' => $token]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->ok("Successfully logged out");
    }
}
