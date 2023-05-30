<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SocailController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
});
Route::middleware('auth:api')->group(function () {
Route::get('logout', [AuthController::class, 'logout']);
Route::post('profile', [AuthController::class, 'profile']);
Route::post('change-pass', [AuthController::class, 'changePass']);
});
Route::post('mail', [AuthController::class, 'send']);
Route::post('forgot-password', [AuthController::class, 'forgetPass']);
Route::delete('user/{id}',  [AuthController::class, 'delete']);

// Post Crud 
Route::get('posts', [PostController::class, 'index']);
Route::post('create', [PostController::class, 'store']);
Route::get('posts/{post}', [PostController::class, 'show']);
Route::post('posts/{post}', [PostController::class, 'update']);
Route::delete('posts/{post}', [PostController::class, 'destroy']);
// Search Post By Keyword
Route::get('search',[PostController::class, 'search']);





