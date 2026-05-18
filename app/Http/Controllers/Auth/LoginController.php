<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class LoginController extends Controller
{
    
    public function index()
    {
        return view('login');
    }

    public function authenticate(Request $request)
    {
        // Lógica de autenticação
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
        // Aqui você pode usar o Auth para tentar autenticar o usuário
        if(Auth::attempt($credentials)){
            $request->session()->regenerate();

            return redirect()->intended('/');
        } else {
            return back()->withErrors([
                'email' => 'As credenciais fornecidas estão incorretas.',
            ]);
        }
    }
}
