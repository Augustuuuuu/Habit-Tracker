<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;


Route::get('/',[SiteController::class, 'index']);

// MVC
// Model -> Database Interaction (Bando de dados)
// View -> User Interface (O que o usuário vê, HTML)
// Controller -> Business Logic (O cerébro: Lógica de Negócio, onde as regras do sistema são aplicadas)

