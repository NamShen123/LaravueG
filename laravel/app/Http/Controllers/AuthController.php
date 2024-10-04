<?php

namespace App\Http\Controllers;

use App\Models\Departments;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class AuthController extends Controller
{

    function login(Request $request)
    {
        $credentials = [
            'username' => $request['username'],
            'password' => $request['password']
        ];
        if(!Auth::attempt($credentials)){
            return response()->json([
                'message' => 'Invalid login credentials',
            ], 401);
        };

        $user = Auth::user();

        $roles = Departments::get()->mapWithKeys(function ($item) {
            return [$item['id'] => $item['name']];
        });

        $user->rolename = $roles[$user->departments_id];

        $user->tokens()->delete();

        $token = $user->createToken('SPA Token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ]);
    }

    function logout(Request $request)
    {
        $request?->user()?->currentAccessToken()?->delete();
        return response()->json([
            "message" => "session end"
        ]);
    }
}
