<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Mail\SendWelcomeEmailToUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{

    public function register(RegisterRequest $request)
    {
        $image = $request->avatar;
        $url = "";
        if ($image != null) {
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload'), $imageName);
            $url = "upload/" . $imageName;
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'avatar' => $url,
            'role' => ["User"],
            'password' => Hash::make($request->password),
        ]);

        Mail::to($user->email)->send(new SendWelcomeEmailToUser($user));
        $token = $user->createToken('myapptoken')->plainTextToken;
        $response = [
            'status' => true,
            'locale' => app()->getLocale(),
            'message' => __('Registered successfully!'),
            'data' => [
                'user' => $user,
                'token' => $token
            ]
        ];

        return response($response, 201);
    }
}
