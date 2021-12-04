<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function login(LoginRequest $request){

        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {

            return response(['status' => false, 'message' => 'invalid email or password'], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;
        $response = [
            'status'=>true,
            'message'=>'login successfully!',
            'data' =>[
                'user'=>$user,
                'token'=>$token
            ]
        ];

        return response($response, 201);
    }


    public function logout()
    {
        auth()->user()->tokens()->delete();
        // auth()->logout();
        $response = [
            'status' => true,
            'message' => 'Logout successfully',
        ];

        return response($response, 201);
    }
}
