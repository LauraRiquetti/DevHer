<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\User;
use App\Models\Vendedora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    /**
     * Exibe a tela de Login
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Processa a autenticação única para qualquer perfil (Admin, Cliente, Vendedora)
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Verificação dupla de admin (Garante que vai ler o banco corretamente)
            if ($user->role === 'admin' || $user->admin === 'admin') {
                return redirect()->intended('/admin'); // <-- Corrigido para /admin
            }

            // REDIRECIONA PARA A TELA INICIAL (WELCOME)
            return redirect()->intended(route('home'))->with('success', 'Bem-vinda de volta!');
        }

        return back()->withErrors([
            'email' => 'As credenciais informadas não correspondem aos nossos registros.',
        ])->onlyInput('email');
    }

    /**
     * Exibe o formulário de cadastro público
     */
    public function showRegisterForm()
    {
        return view('auth.cadastro');
    }

    /**
     * Processa o cadastro público e vincula ao perfil correto
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'nome'            => ['required', 'string', 'max:255'],
            'email'           => ['required', 'string', 'email', 'max:255', 'unique:users,email', 'unique:clientes,email', 'unique:vendedoras,email'],
            'password'        => ['required', 'string', 'min:8', 'confirmed'],
            'cpf'             => ['required', 'string'],
            'telefone'        => ['required', 'string'],
            'data_nascimento' => ['required', 'date'],
            'tipo_perfil'     => ['required', 'in:cliente,vendedora'],
            'cep'             => ['required', 'string'],
            'rua'             => ['required', 'string'],
            'numero'          => ['required', 'numeric'],
            'bairro'          => ['required', 'string'],
            'cidade'          => ['required', 'string'],
            'estado'          => ['required', 'string', 'max:2'],
        ]);

        // Trata máscaras mantendo apenas os números como STRING (evita estouro de int no MySQL)
        $cpfLimpo = preg_replace('/[^0-9]/', '', $validated['cpf']);
        $cepLimpo = preg_replace('/[^0-9]/', '', $validated['cep']);

        // Uso de transação para garantir integridade (ou cria ambos, ou aborta)
        $user = DB::transaction(function () use ($validated, $cpfLimpo, $cepLimpo) {
            // 1. Cria a conta de autenticação base
            $user = User::create([
                'name'     => $validated['nome'],
                'email'    => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role'     => $validated['tipo_perfil'],
            ]);

            // 2. Prepara os dados detalhados para a tabela específica
            $dadosPerfil = [
                'user_id'         => $user->id,
                'nome'            => $validated['nome'],
                'email'           => $validated['email'],
                'password'        => Hash::make($validated['password']),
                'CPF'             => $cpfLimpo, // Enviado como String
                'telefone'        => $validated['telefone'],
                'data_nascimento' => $validated['data_nascimento'],
                'CEP'             => $cepLimpo, // Enviado como String
                'rua'             => $validated['rua'],
                'bairro'          => $validated['bairro'],
                'cidade'          => $validated['cidade'],
                'estado'          => strtoupper($validated['estado']),
                'numero'          => (int) $validated['numero'],
                'role'            => $validated['tipo_perfil'],
            ];

            // 3. Salva no model do perfil correspondente
            if ($validated['tipo_perfil'] === 'vendedora') {
                Vendedora::create($dadosPerfil);
            } else {
                Cliente::create($dadosPerfil);
            }

            return $user;
        });

        // Autentica o novo usuário e redireciona
        Auth::login($user);

        return redirect('/login')->with('success', 'Cadastro realizado com sucesso.');
    }

    /**
     * Encerra a sessão do usuário
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Sessão encerrada.');
    }

    /**
     * Tela de solicitação de recuperação de senha
     */
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Envia o e-mail de redefinição de senha
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(
            ['email' => 'required|email|exists:users,email'],
            ['email.exists' => 'Não encontramos uma conta cadastrada com este e-mail.']
        );

        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', 'Enviamos o link de redefinição para o seu e-mail!');
        }

        return back()->withErrors(['email' => 'Não foi possível enviar o e-mail. Tente novamente.']);
    }
}