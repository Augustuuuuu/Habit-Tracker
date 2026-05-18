<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
class LoginController extends Controller
{

    public function index()
    {
        return view('login');
    }

    public function authenticate(Request $request)
    {
        // Faz a autenticação do usuário com base nas credenciais fornecidas e redireciona para o dashboard se for bem-sucedida, ou retorna um erro caso contrário.
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
        if(Auth::attempt($credentials)){
            $request->session()->regenerate();

            return redirect()->intended(route('site.dashboard'));
        }

        return back()->withErrors([
            'email' => 'As credenciais fornecidas estão incorretas.',
        ]);

    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(route('site.index'));
}
}
