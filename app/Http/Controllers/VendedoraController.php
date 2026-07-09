<?php

namespace App\Http\Controllers;

use App\Models\Vendedora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class VendedoraController extends Controller
{
    public function buscarCep($cep)
    {
        $response = Http::get("https://viacep.com.br/ws/$cep/json/");

        $dados = $response->json();

        return response()->json($dados);
    }

    public function index()
    {
        $vendedoras = Vendedora::orderByDesc('id')->get();

        return view('vendedoras.index', compact('vendedoras'));
    }

    public function create()
    {
        return view('vendedoras.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string',
            'email' => 'required|email|unique:vendedoras,email',
            'password' => 'required|min:6',
            'data_nascimento' => 'required|date',
            'CEP' => 'required',
            'rua' => 'required|string',
            'bairro' => 'required|string',
            'cidade' => 'required|string',
            'estado' => 'required|string',
            'numero' => 'required',
        ]);

        Vendedora::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'data_nascimento' => $request->data_nascimento,
            'CEP' => $request->CEP,
            'rua' => $request->rua,
            'bairro' => $request->bairro,
            'cidade' => $request->cidade,
            'estado' => $request->estado,
            'numero' => $request->numero,
        ]);

        return redirect('/login')->with('success', 'Conta criada! Agora faça login.');
    }

    /**
     * Mostra o formulário de login.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Processa o login (sem usar o sistema de Auth padrão do Laravel,
     * já que o model Vendedora não é um "users" nativo).
     */
    public function login(Request $request)
    {
        $credenciais = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $vendedora = Vendedora::where('email', $credenciais['email'])->first();

        if (!$vendedora || !Hash::check($credenciais['password'], $vendedora->password)) {
            return back()
                ->withErrors(['email' => 'E-mail ou senha inválidos.'])
                ->onlyInput('email');
        }

        // Guarda os dados da vendedora logada na sessão
        session([
            'vendedora_id' => $vendedora->id,
            'vendedora_nome' => $vendedora->nome,
            'vendedora_email' => $vendedora->email,
        ]);

        $request->session()->regenerate();

        return redirect('/')->with('success', 'Login realizado com sucesso!');
    }

    /**
     * Faz logout limpando a sessão da vendedora.
     */
    public function logout(Request $request)
    {
        $request->session()->forget(['vendedora_id', 'vendedora_nome', 'vendedora_email']);
        $request->session()->regenerate();

        return redirect('/login');
    }

    public function update(Request $request, Vendedora $vendedora)
    {
        $rules = [
            'nome'            => 'required|string',
            'email'           => 'required|email|unique:vendedoras,email,' . $vendedora->id,
            'data_nascimento' => 'required|date',
            'CEP'             => 'required',
            'rua'             => 'required|string',
            'bairro'          => 'required|string',
            'cidade'          => 'required|string',
            'estado'          => 'required|string',
            'numero'          => 'required',
            'password'        => 'nullable|min:6',
        ];

        $validated = $request->validate($rules);

        $dados = [
            'nome'            => $validated['nome'],
            'email'           => $validated['email'],
            'data_nascimento' => $validated['data_nascimento'],
            'CEP'             => $validated['CEP'],
            'rua'             => $validated['rua'],
            'bairro'          => $validated['bairro'],
            'cidade'          => $validated['cidade'],
            'estado'          => $validated['estado'],
            'numero'          => $validated['numero'],
        ];

        // Só adiciona a senha se o usuário digitou algo
        if ($request->filled('password')) {
            $dados['password'] = Hash::make($request->password);
        }

        // Salva tudo de uma vez
        $vendedora->update($dados);

        return redirect()->route('vendedoras.index')->with('success', 'Perfil atualizado!');
    }

    public function destroy(Vendedora $vendedora)
    {
        $vendedora->delete();
        return redirect()->route('vendedoras.index');
    }
}