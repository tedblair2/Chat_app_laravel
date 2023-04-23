<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [UserController::class, 'home']);
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
Route::get('/index', [UserController::class, 'index']);
Route::post('/logout', [UserController::class, 'logout']);
Route::post('/set_session', [ChatController::class, 'set_session']);
Route::post('/send_message', [ChatController::class, 'send_message']);
Route::post('/get_messages', [ChatController::class, 'get_messages']);
Route::get('/get_users', [UserController::class, 'get_all_users']);
Route::post('/search_user', [UserController::class, 'search_user']);
