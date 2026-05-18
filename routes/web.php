<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\Auth\LoginController;

// Site
Route::get('/',[SiteController::class, 'index'])->name('site.index');

// Login 
Route::get('/login', [LoginController::class, 'index'])->name('site.login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('site.login');
// Auth
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [SiteController::class, 'dashboard'])->name('site.dashboard');

    Route::post('/logout', [LoginController::class, 'logout'])->name('site.logout');
});


// MVC
// Model -> Database Interaction (Bando de dados)
// View -> User Interface (O que o usuário vê, HTML)
// Controller -> Business Logic (O cerébro: Lógica de Negócio, onde as regras do sistema são aplicadas)

