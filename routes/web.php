<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $user = Auth::user();
    if ($user) {
        return redirect()->route('dashboard');
    }
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard', ['username' => Auth::user()->username]);
})->middleware('auth')->name('dashboard');

Route::get('/login', [AuthController::class, 'create'])
    ->name('login');

Route::post('/login', [AuthController::class, 'store'])
    ->name('login');

Route::post('/logout', [AuthController::class, 'destroy'])
    ->name('logout');
