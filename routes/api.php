<?php

use App\Http\Controllers\Api\AuthController;
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
    Route::get('/users', [UserController::class, 'index'])->name('index');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('show');
    Route::post('/users', [UserController::class, 'store'])->name('store');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('destroy');
    Route::post('/users-update-avatar/{id}', [UserController::class,'updateAvatar']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout')->middleware('auth:sanctum');
Route::post('/register', [RegisterController::class, 'register'])->name('auth.register');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');


