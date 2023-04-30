<?php

use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\VootController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('user/register', [UserController::class, 'register']);
Route::post('user/login', [UserController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function () {

    //Post module
    Route::get('post/list', [PostController::class, 'index']);
    Route::post('post/store', [PostController::class, 'store']);
    Route::post('post/update/{id}', [PostController::class, 'update']);
    Route::get('post/show/{id}', [PostController::class, 'show']);
    Route::delete('post/delete/{id}', [PostController::class, 'destroy']);

    //Voots module
    Route::post('voot/up-voot', [VootController::class, 'upVoot']);
    Route::post('voot/down-voot', [VootController::class, 'downVoot']);

    //comment module
    Route::post('comment/store', [CommentController::class, 'store']);
    Route::delete('comment/delete/{id}', [CommentController::class, 'destroy']);
});
