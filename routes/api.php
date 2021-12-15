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
    Route::post('/users', [UserController::class, 'store'])->name('store');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('show');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('destroy');
    Route::put('/edit/{id}', [UserController::class,'edit'])->name('edit');
    Route::post('/updateAvatar/{id}', [UserController::class,'UpdateAvatar'])->name('updateAvatar');

    //Posts
    Route::get('/posts', [PostsController::class, 'index'])->name('indexPosts');
    Route::post('/posts', [PostsController::class, 'store'])->name('storePosts');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout')->middleware('auth:sanctum');
Route::post('/register', [RegisterController::class, 'register'])->name('auth.register');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

// Test cache
Route::get('/abc/{id}', [UserController::class, 'abc']);
// Route::get('/users', [UserController::class, 'index'])->name('index');
// Route::get('/users/{id}', [UserController::class, 'show'])->name('show');
// Route::get('/userss/{id}', [UserController::class, 'destroy'])->name('destroy');
//Route::get('/edit/{id}', [UserController::class,'edit'])->name('edit');



