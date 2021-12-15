<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{
    public function abc($id)
    {
        $value = Cache::rememberForever('key_' . $id, function () use ($id) {
            return User::find($id);
        });
        dd($value);
    }

    public function index()
    {

        $value = Cache::rememberForever('key', function () {

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
        });

        Cache::forget('key');

        return $value;
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

    public function show($id)
    {
        $value = Cache::rememberForever('key_' . $id, function () use ($id) {

            $users = User::find($id);

            if (!$users) {

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
        });

        Cache::forget('key_' . $id);

        return $value;
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */

    public function edit(UpdateUserRequest $request, $id)
    {

        $value = Cache::rememberForever('key_' . $id, function () use ($id, $request) {

            $users = User::FindorFail($id);

            $users->update([
                'name' => $request->get('name'),
                'gender' => $request->get('gender'),
                'birth_date' => $request->get('birth_date'),
            ]);

            return response([
                'status' => true,
                'locale' => app()->getLocale(),
                'message' => __('Update success'),
                'data' => [
                    'user' => $users
                ]
            ]);
        });

        Cache::forget('key_' . $id);

        return $value;
    }

    public function UpdateAvatar(UpdateUserRequest $request, $id)
    {
        $value = Cache::rememberForever('key_' . $id, function () use ($id, $request) {
            $users = User::FindorFail($id);

            $image = $request->avatar;
            if (!empty($image)) {
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('upload'), $imageName);
                $newAvatarUrl = "upload/" . $imageName;
            }

            $users->update([
                'name' => $request->get('name'),
                'avatar' => empty($newAvatarUrl) ? $users->avatar : $newAvatarUrl
            ]);

            return response([
                'status' => true,
                'locale' => app()->getLocale(),
                'message' => __('Update success'),
                'data' => [
                    'user' => $users
                ]
            ]);
        });

        Cache::forget('key_' . $id);

        return $value;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $value = Cache::rememberForever('key_' . $id, function () use ($id) {
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
        });

        Cache::forget('key_' . $id);

        return $value;
    }
}
