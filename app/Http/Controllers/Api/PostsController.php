<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostsRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Posts;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class PostsController extends Controller
{
    public function test()
    {
        $user = User::find(2)->posts()->where('title', 'ABCDEF')->first();
        dd($user);
        // $post = Posts::find(6)->user;
        // dd($post);
    }

    public function index()
    {
        $page = request()->get('page', 1);
        $perPage = request()->get('per_page', 2);
        $keyword = request()->get('keyword');

        $cacheKey = "post_index_page_{$page}_per_page_{$perPage}_keyword_{$keyword}";

        $posts = Cache::tags(['post_index'])->rememberForever($cacheKey, function ()  use ($perPage, $keyword) {

            return Posts::when($keyword, function ($query) use ($keyword) {

                return $query->where('title', 'like', '%' . $keyword . '%');
            })->paginate($perPage);
        });

        return response()->json([
            'status' => true,
            'message' => __('List'),
            'data' => $posts
        ], 200);
    }

    public function store(PostsRequest $request)
    {
        $post = Posts::create([
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'author_id' => $request->input('author_id'),
        ]);

        Cache::put('post_' . $post->id, $post);
        Cache::tags(['post_index'])->flush();

        return response([
            'status' => true,
            'locale' => app()->getLocale(),
            'message' => __('Created successfully!'),
            'data' => [
                'post' => $post
            ]
        ], 201);
    }

    public function edit(UpdatePostRequest $request, $id)
    {
        $post = $this->getPostById($id);

        $image = $request->avatar;
        if (!empty($image)) {
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploadFeatureImgPosts'), $imageName);
            $newAvatarUrl = "upload/" . $imageName;
        }

        $post->update([
            'title' => $request->get('title', $post->title),
            'body' => $request->get('body', $post->body),
            'author_id' => $request->get('author_id', $post->author_id),
            'feature_img' => empty($newAvatarUrl) ? $post->feature_img : $newAvatarUrl
        ]);

        Cache::put('post_' . $id, $post);
        Cache::tags(['post_index'])->flush();

        return response([
            'status' => true,
            'locale' => app()->getLocale(),
            'message' => __('Update success'),
            'data' => [
                'post' => $post
            ]
        ]);
    }

    public function destroy($id)
    {
        $post = $this->getPostById($id);

        $post->delete();

        Cache::forget('post_' . $id);
        Cache::tags(['post_index'])->flush();

        return response([
            'status' => true,
            'locale' => app()->getLocale(),
            'message' => __('Delete post successfully!'),
        ], 200);
    }

    protected function getPostById($id)
    {
        return Cache::rememberForever('post_' . $id, function () use ($id) {
            return Posts::findOrFail($id);
        });
    }
}
