<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HabitController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SiteController::class, 'index'])
    ->name('site.index');

// Autenticação e cadastro
Route::get('/login', [LoginController::class, 'index'])
    ->name('site.login');

Route::post('/login', [LoginController::class, 'authenticate'])
    ->name('login.authenticate');

Route::get('/cadastro', [RegisterController::class, 'index'])
    ->name('site.register');

Route::post('/cadastro', [RegisterController::class, 'store'])
    ->name('auth.register');

/*Rotas protegidas: apenas usuários autenticados podem acessar o dashboard, gerenciar seus hábitos e realizar logout.*/

Route::middleware('auth')->group(function () {
    /*    Route::get('/dashboard', [SiteController::class, 'dashboard'])
            ->name('site.dashboard');*/

    Route::post('/logout', [LoginController::class, 'logout'])
        ->name('site.logout');

    Route::resource('/dashboard/habits', HabitController::class)->except('show');
});
