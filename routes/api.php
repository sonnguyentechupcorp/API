<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostsController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;
//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Mail;
//use App\Http\Resources\UserResource;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => ['auth:sanctum'], 'as' => 'user.'], function () {

    //User
    Route::get('/users', [UserController::class, 'index'])->name('index');
    Route::post('/user', [UserController::class, 'store'])->name('store');
    Route::get('/user/{id}', [UserController::class, 'show'])->name('show');
    Route::delete('/deleteUser/{id}', [UserController::class, 'destroy'])->name('destroy');
    Route::put('/editUser/{id}', [UserController::class,'edit'])->name('edit');

    //Posts
    Route::get('/posts', [PostsController::class, 'index'])->name('indexPosts');
    Route::post('/post', [PostsController::class, 'store'])->name('storePost');
    Route::put('/editPost/{id}', [PostsController::class, 'edit'])->name('editPost');
    Route::delete('/deletePost/{id}', [PostsController::class, 'destroy'])->name('destroyPost');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout')->middleware('auth:sanctum');
Route::post('/register', [RegisterController::class, 'register'])->name('auth.register');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

//Test
Route::get('/test', [PostsController::class, 'test'])->name('indexPosts');





