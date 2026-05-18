<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\Auth\LoginController;

// Site
Route::get('/',[SiteController::class, 'index']);

// Login 
Route::get('/login', [LoginController::class, 'index']);
Route::post('/login', [LoginController::class, 'authenticate']);
// MVC
// Model -> Database Interaction (Bando de dados)
// View -> User Interface (O que o usuário vê, HTML)
// Controller -> Business Logic (O cerébro: Lógica de Negócio, onde as regras do sistema são aplicadas)

