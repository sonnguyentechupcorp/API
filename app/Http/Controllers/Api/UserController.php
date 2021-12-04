<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        //$userss = User::paginate(2);
        //$query = User::query();
        // if (request ('user_id') ) {
        //     $query -> where('id', request ('user_id'));
        // }
        // if (request ('name')) {
        //     $query-> where('name', request ('name'));
        // }
        //$users = $query->get();
        $users = User::when(request('user_id'), function ($query) {

            return $query->where('id', request('user_id'));
        })->when(request('name') , function ($query) {

            return $query->where('name', request('name'));
        })->paginate(2);

        return response()->json($users, 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {

        $users = User::where('email', $request->email)->first();
        if (empty($users)){
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->role = ["User"];
            $user->gender = $request->input('gender');
            $user->birth_date = $request->input('birth_date');
            $user->password = Hash::make($request->input('password'));
            $user->save();

            return new UserResource($user);
        }

        return response(['status' => false, 'message' => 'User already exists']);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $users = User::where('id', $id)->get();
        //dd($users);

        return UserResource::collection($users) ;
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
    public function update()
    {

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
        //dd($users);
        if($users)
        {
            $users -> delete();

            return ["result" => "Xoa thanh cong"];


        }else{

            return ["result" => "Khong ton tai users"];
        }





    }
    public function search($name)
    {
        $users = User::where('name', 'like', '%'.$name.'%')->get();

        return $users;

    }
}
