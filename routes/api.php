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

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::post('/users', [UserController::class, 'store']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
    Route::get('/search/{name}', [UserController::class, 'search']);
});
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Route::apiResource('users', UserController::class);
// Route::get('/users', function () {
//     return new UserResource(User::all());
// });


//SEND MAIL
        // Route::get('send-mail', function () {

        //     $details = [
        //         'title' => 'Mail from ABC',
        //         'body' => 'welcome'
        //     ];

        //     \Mail::to('asdsad@gmail.com')->send(new \App\Mail\MyTestMail($details));

        //     dd("Email is Sent.");
        // });
