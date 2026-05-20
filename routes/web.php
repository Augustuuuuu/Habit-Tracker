<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HabitController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

// Site
Route::get('/',[SiteController::class, 'index'])->name('site.index');
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
Route::get('/cadastro', [RegisterController::class, 'index'])->name('site.register');
Route::post('/cadastro', [RegisterController::class, 'store'])->name('auth.register');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [SiteController::class, 'dashboard'])
        ->name('site.dashboard');

    Route::post('/logout', [LoginController::class, 'logout'])
        ->name('site.logout');

    // Habits
    Route::get('/dashboard/habits/create', [HabitController::class, 'create'])
        ->name('habit.create');
    Route::post('/dashboard/habits/create', [HabitController::class, 'store'])
        ->name('habit.store');
    Route::delete('/dashboard/habits/{habit}', [HabitController::class, 'destroy'])
        ->name('habit.destroy');
});


// MVC
// Model -> Database Interaction (Bando de dados)
// View -> User Interface (O que o usuário vê, HTML)
// Controller -> Business Logic (O cerébro: Lógica de Negócio, onde as regras do sistema são aplicadas)

