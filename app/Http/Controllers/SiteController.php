<?php

namespace App\Http\Controllers;
class SiteController extends Controller
{
    public function index()
    {
        $name = "Augusto";
        $habits = [
            'Beber água',
            'Ir para a academia',
            'Ler um livro',
            'Meditar',
        ];

        // return view('home', [
        //     'name' => $name,
        //     'habits' => $habits
        // ]);
        return view('home', compact('name', 'habits'));
    }

    public function dashboard()
    {
        return view('dashboard');
    }
}
