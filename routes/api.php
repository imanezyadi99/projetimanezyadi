<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;


use App\Http\Resources\UserResource;



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
    return new UserResource ($request->user());
});

Route::post('login',[LoginController::class,'login']);
Route::post('register',[RegisterController::class, 'register']);
Route::resource('users', HomeController::class);

Route::post('/logout', function (Request $request) {
    $request->user()->tokens()->delete();
    return response()->json(['message' => 'User logged out successfully.'], 200);
})->middleware('auth:sanctum');