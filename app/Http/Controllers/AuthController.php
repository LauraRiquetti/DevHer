<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Método para mostrar o formulário (GET)
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Método para PROCESSAR o login (POST)
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required','email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Verificação dupla de admin (Garante que vai ler o banco corretamente)
            if ($user->role === 'admin' || $user->admin === 'admin') {
                return redirect()->intended('/admin'); // <-- Corrigido para /admin
            }

            // Se for cliente comum, vai para a loja
            return redirect()->intended('/home');
        }

        return back()->withErrors([
            'email' => 'Usuário ou senha inválidos'
        ]);
    }

    // Método para fazer o LOGOUT
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Você saiu com sucesso!');
    }
}