<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BoardTemplateController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index'])
    ->name('welcome');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

Route::get('/login', [AuthController::class, 'create'])
    ->name('login');

Route::post('/login', [AuthController::class, 'store'])
    ->name('login');

Route::post('/logout', [AuthController::class, 'destroy'])
    ->name('logout');

Route::resource('templates', BoardTemplateController::class)
    ->except(['update', 'destroy'])
    ->name('index', 'templates')
    ->name('show', 'template-show')
    ->name('create', 'template-create')
    ->name('edit', 'template-edit')
    ->name('store', 'template-store');
