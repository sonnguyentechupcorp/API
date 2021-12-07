<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function login(LoginRequest $request)
    {

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {

            return response(['status' => false, 'message' => __('Invalid email or password.')], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;
        $response = [
            'status' => true,
            'locale' => app()->getLocale(),
            'message' => __('Login successfully!'),
            'data' => [
                'user' => $user,
                'token' => $token
            ]
        ];

        return response($response, 200);
    }


    public function logout()
    {

        auth()->user()->tokens()->delete();
        $response = [
            'status' => true,
            'locale' => app()->getLocale(),
            'message' => __('Logout successfully!'),
        ];

        return response($response, 200);
    }
}
