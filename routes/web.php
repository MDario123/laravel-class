<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $user = Auth::user();
    if ($user) {
        $username = $user->username;
        Auth::logout(); // Log the user out
        return $username;
    }
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login');
