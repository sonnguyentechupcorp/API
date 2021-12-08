<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index()
    {
        $users = User::when(request('user_id'), function ($query) {

            return $query->where('id', request('user_id'));
        })->when(request('name'), function ($query) {

            return $query->where('name', request('name'));
        })->paginate(2);

        return response()->json([
            'status' => true,
            'message' => __('List'),
            'data' => $users
        ], 200);
    }

    public function store(UserRequest $request)
    {

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'role' => ["User"],
            'gender' => $request->input('gender'),
            'birth_date' => $request->input('birth_date'),
            'password' => Hash::make($request->password),
        ]);

        return response([
            'status' => true,
            'locale' => app()->getLocale(),
            'message' => __('Created successfully!'),
            'data' => [
                'user' => $user
            ]
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $users = User::find($request->id);

        if(!$users){

            return response([
                'status' => false,
                'locale' => app()->getLocale(),
                'message' => __('User does not exist.'),
            ], 404);
        }

        return response([
            'status' => true,
            'locale' => app()->getLocale(),
            'message' => __('User information.'),
            'data' => [
                'user' => $users
            ]
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function updateAvatar(UpdateUserRequest $request, $id)
    {
        $users = User::find($id);

        if(!$users){

            return response([
                'status' => false,
                'locale' => app()->getLocale(),
                'message' => __('User does not exist.'),
            ], 404);
        }

        if($request->email){

            return response([
                'status' => false,
                'locale' => app()->getLocale(),
                'message' => __('Can not change email.'),
            ], 404);
        }

        $users->name = $request->name;
        $users->gender = $request->gender;
        $users->birth_date = $request->birth_date;

        if ($request->avatar != '') {
            $image = $request->avatar;
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload'), $imageName);
            $url = "upload/" . $imageName;
            $users->update(['avatar' => $url]);
        }

        $users->save();

        return response([
            'status' => true,
            'locale' => app()->getLocale(),
            'message' => __('Update success'),
            'data' => [
                'user' => $users
            ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $users = User::find($id);

        if ($users) {
            $users->delete();

            return response([
                'status' => true,
                'locale' => app()->getLocale(),
                'message' => __('Delete user successfully!'),
            ], 200);
        } else {

            return response([
                'status' => false,
                'locale' => app()->getLocale(),
                'message' => __('Users do not exist.'),
            ], 404);
        }
    }
}
