<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

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
    /**
     * Mostra a tela de "Esqueci a Senha" (GET)
     */
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Processa o envio do e-mail de recuperação pelo Gmail (POST)
     */
    public function sendResetLinkEmail(Request $request)
    {
        // 1. Valida se o e-mail foi digitado e se ele realmente existe no banco
        $request->validate(
            ['email' => 'required|email|exists:users,email'],
            ['email.exists' => 'Este e-mail não está cadastrado no nosso sistema.']
        );

        // 2. Dispara o e-mail usando o motor do Laravel + configurações do seu .env
        $status = Password::sendResetLink($request->only('email'));

        // 3. Retorna o usuário com o feedback correto
        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', 'Enviamos o link de recuperação para o seu e-mail!');
        }

        return back()->withErrors(['email' => 'Não foi possível enviar o e-mail. Tente novamente.']);
    }
}