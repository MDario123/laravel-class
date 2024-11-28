<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BoardTemplateController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index'])
    ->name('welcome');

Route::get('/login', [AuthController::class, 'create'])
    ->name('login');

Route::post('/login', [AuthController::class, 'store'])
    ->name('login');

Route::post('/logout', [AuthController::class, 'destroy'])
    ->name('logout');

Route::resource('templates', BoardTemplateController::class)
    ->except(['index', 'update', 'destroy'])
    ->name('index', 'templates')
    ->name('show', 'template-show')
    ->name('create', 'template-create')
    ->name('edit', 'template-edit')
    ->name('store', 'template-store');

Route::resource('games', GameController::class)
    ->only(['create', 'store', 'edit', 'update'])
    ->name('create', 'game-create')
    ->name('store', 'game-store')
    ->name('edit', 'game-edit')
    ->name('update', 'game-update');
