<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostsRequest;
use App\Models\Posts;

class PostsController extends Controller
{

    public function index()
    {

        $posts = Posts::when(request('posts_id'), function ($query) {

            return $query->where('id', request('posts_id'));
        })->when(request('title'), function ($query) {

            return $query->where('title', request('title'));
        })->paginate(2);

        return response()->json([
            'status' => true,
            'message' => __('List'),
            'data' => $posts
        ], 200);
    }

    public function store(PostsRequest $request)
    {
        $newFeauterImgUrl = '';
        $image = $request->avatar;
        if (!empty($image)) {
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploadFeatureImgPosts'), $imageName);
            $newFeauterImgUrl = "upload/" . $imageName;
        }

        $posts = Posts::create([
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'feature_img' => $newFeauterImgUrl,
        ]);

        return response([
            'status' => true,
            'locale' => app()->getLocale(),
            'message' => __('Created successfully!'),
            'data' => [
                'user' => $posts
            ]
        ], 201);
    }
 }
