<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisteRequest;
use App\Models\User;
use App\Mail\MyTestMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{

    public function register(RegisteRequest $request)
    {
        // $fields = $request->validate([
        //     'name' =>'required|string',
        //     'email'=>'required|string|unique:users,email',
        //     'password' =>'required|string|confirmed'
        // ]);
        $user = User::where('email', $request->email)->first();
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'role' => ["User"],
            'password' => Hash::make($request->password),
        ]);

        //Send mail
        $details = [
            'name' => $request->name,
            'email' => $request->email
        ];
         Mail::to($details['email'])->send(new MyTestMail($details));
        $token = $user->createToken('myapptoken')->plainTextToken;
        $response = [
            'status' => true,
            'message' => 'registered successfully!',
            'data' => [
                'user' => $user,
                'token' => $token
            ]
        ];

        return response($response, 201);
    }
}
