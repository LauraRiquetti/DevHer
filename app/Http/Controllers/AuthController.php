<?php

namespace App\Http\Controllers;

// Importação das Models necessárias para manipulação no banco de dados
use App\Models\Cliente;
use App\Models\User;
use App\Models\Vendedora;

// Importação das Facades e utilitários do Laravel
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Exibe a tela de Login
     */
    public function showLoginForm()
    {
        // Retorna a view localizada em resources/views/auth/login.blade.php
        return view('auth.login');
    }

    /**
     * Processa a autenticação única para qualquer perfil (Admin, Cliente, Vendedora)
     */
    public function login(Request $request)
    {
        // Valida as credenciais recebidas da requisição (e-mail obrigatório e válido; senha obrigatória)
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Tenta autenticar o usuário no banco usando a Facade Auth
        if (Auth::attempt($credentials)) {
            // Regenera o ID da sessão para prevenir ataques de fixação de sessão
            $request->session()->regenerate();

            // Obtém o Model do usuário autenticado no momento
            $user = Auth::user();

            // Verificação dupla de admin (Garante que vai ler o banco corretamente)
            if ($user->role === 'admin' || $user->admin === 'admin') {
                return redirect()->intended('/admin'); // <-- Corrigido para /admin
            }

            // REDIRECIONA PARA A TELA INICIAL (WELCOME)
            return redirect()->intended(route('home'))->with('success', 'Bem-vinda de volta!');
        }

        // Se a autenticação falhar, retorna à página anterior preenchendo apenas o e-mail e exibindo erro
        return back()->withErrors([
            'email' => 'As credenciais informadas não correspondem aos nossos registros.',
        ])->onlyInput('email');
    }

    /**
     * Exibe o formulário de cadastro público
     */
    public function showRegisterForm()
    {
        // Retorna a view localizada em resources/views/auth/cadastro.blade.php
        return view('auth.cadastro');
    }

    /**
     * Processa o cadastro público e vincula ao perfil correto
     */
    public function register(Request $request)
    {
        // Valida as informações preenchidas no formulário de cadastro
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
            // 1. Cria a conta de autenticação base na tabela 'users'
            $user = User::create([
                'name'     => $validated['nome'],
                'email'    => $validated['email'],
                'password' => Hash::make($validated['password']), // Criptografa a senha
                'role'     => $validated['tipo_perfil'],
            ]);

            // 2. Prepara os dados detalhados para a tabela específica (clientes ou vendedoras)
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

        return redirect()->route('home')->with('success', 'Cadastro realizado com sucesso! Seja bem-vinda.');
    }

    /**
     * Encerra a sessão do usuário
     */
    public function logout(Request $request)
    {
        // Desloga o usuário
        Auth::logout();
        
        // Invalida a sessão atual e regenera o token CSRF por segurança
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redireciona para a página inicial
        return redirect('/')->with('success', 'Sessão encerrada.');
    }

    /**
     * Tela de solicitação de recuperação de senha
     */
    public function showForgotPasswordForm()
    {
        // Retorna a view para solicitação de reset de senha
        return view('auth.forgot-password');
    }

    /**
     * Envia o e-mail de redefinição de senha
     */
    public function sendResetLinkEmail(Request $request)
    {
        // Valida se o e-mail existe na tabela 'users'
        $request->validate(
            ['email' => 'required|email|exists:users,email'],
            ['email.exists' => 'Não encontramos uma conta cadastrada com este e-mail.']
        );

        // Envia o link com o token via Password broker do Laravel
        $status = Password::sendResetLink($request->only('email'));

        // Se o envio for bem-sucedido, retorna exibindo mensagem de sucesso
        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', 'Enviamos o link de redefinição para o seu e-mail!');
        }

        // Se falhar, retorna com mensagem de erro
        return back()->withErrors(['email' => 'Não foi possível enviar o e-mail. Tente novamente.']);
    }

    /**
     * Processa a redefinição de senha
     */
    public function updatePassword(Request $request)
    {
        // 1. Valida os dados enviados (como no seu form não tem "confirmar senha", validamos apenas a senha)
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8', 
        ]);

        // 2. Tenta redefinir a senha verificando o token
        $status = Password::reset(
            $request->only('email', 'password', 'token'),
            function ($user, string $password) {
                // Altera a senha criptografando com Hash e gera um novo remember_token
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();
            }
        );

        // 3. Verifica se deu certo e redireciona
        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('success', 'Sua senha foi redefinida com sucesso! Faça login para continuar.');
        }

        // Se falhar (ex: token expirado), volta com erro traduzido
        return back()->withErrors(['email' => __($status)]);
    }
}