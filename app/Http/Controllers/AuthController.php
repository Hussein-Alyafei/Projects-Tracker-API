<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('API token for ' . $user->email)->plainTextToken;

        return response()->json([
            'message' => 'The account created successfully',
            'token' => $token
        ], 200);
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

        return response()->json([
            'message' => 'Authenticated',
            'token' => $token
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Successfully logged out',
        ], 200);
    }
}
