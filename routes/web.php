<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/users', [HomeController::class, 'index'])->name('index');
});
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('logout1');

Route::get('/dashboard', [HomeController::class, 'index'])->name('index');

Route::get('/test', function(){
    Auth::user()->unreadNotifications->markAsRead();
})->name('markRead');