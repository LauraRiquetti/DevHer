<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class ClienteController extends Controller
{
    public function buscarCep($cep)
    {
        $cepLimpo = preg_replace('/[^0-9]/', '', $cep);
        $response = Http::get("https://viacep.com.br/ws/{$cepLimpo}/json/");

        return response()->json($response->json());
    }

    public function index()
    {
        $clientes = Cliente::with('user')->orderByDesc('id')->get();

        return view('clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome'            => 'required|string|max:255',
            'email'           => 'required|email|unique:users,email|unique:clientes,email',
            'password'        => 'required|min:8',
            'CPF'             => 'required|string',
            'telefone'        => 'required|string',
            'data_nascimento' => 'required|date',
            'CEP'             => 'required|string',
            'rua'             => 'required|string',
            'bairro'          => 'required|string',
            'cidade'          => 'required|string',
            'estado'          => 'required|string|max:2',
            'numero'          => 'required|numeric',
        ]);

        $cpfLimpo = (int) preg_replace('/[^0-9]/', '', $validated['CPF']);
        $cepLimpo = (int) preg_replace('/[^0-9]/', '', $validated['CEP']);

        // Transação para garantir integridade entre users e clientes
        DB::transaction(function () use ($validated, $cpfLimpo, $cepLimpo) {
            $user = User::create([
                'name'     => $validated['nome'],
                'email'    => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role'     => 'cliente',
            ]);

            Cliente::create([
                'user_id'         => $user->id,
                'nome'            => $validated['nome'],
                'email'           => $validated['email'],
                'password'        => Hash::make($validated['password']),
                'CPF'             => $cpfLimpo,
                'telefone'        => $validated['telefone'],
                'data_nascimento' => $validated['data_nascimento'],
                'CEP'             => $cepLimpo,
                'rua'             => $validated['rua'],
                'bairro'          => $validated['bairro'],
                'cidade'          => $validated['cidade'],
                'estado'          => strtoupper($validated['estado']),
                'numero'          => (int) $validated['numero'],
                'role'            => 'cliente',
            ]);
        });

        return redirect('/login')->with('success', 'Cliente cadastrado com sucesso!');
    }

    public function update(Request $request, Cliente $cliente)
    {
        $validated = $request->validate([
            'nome'            => 'required|string|max:255',
            'email'           => 'required|email|unique:clientes,email,' . $cliente->id,
            'CPF'             => 'required|string',
            'telefone'        => 'required|string',
            'data_nascimento' => 'required|date',
            'CEP'             => 'required|string',
            'rua'             => 'required|string',
            'bairro'          => 'required|string',
            'cidade'          => 'required|string',
            'estado'          => 'required|string|max:2',
            'numero'          => 'required|numeric',
            'password'        => 'nullable|min:8',
        ]);

        $cpfLimpo = (int) preg_replace('/[^0-9]/', '', $validated['CPF']);
        $cepLimpo = (int) preg_replace('/[^0-9]/', '', $validated['CEP']);

        DB::transaction(function () use ($request, $cliente, $validated, $cpfLimpo, $cepLimpo) {
            // Atualiza o perfil do Cliente
            $dadosCliente = [
                'nome'            => $validated['nome'],
                'email'           => $validated['email'],
                'CPF'             => $cpfLimpo,
                'telefone'        => $validated['telefone'],
                'data_nascimento' => $validated['data_nascimento'],
                'CEP'             => $cepLimpo,
                'rua'             => $validated['rua'],
                'bairro'          => $validated['bairro'],
                'cidade'          => $validated['cidade'],
                'estado'          => strtoupper($validated['estado']),
                'numero'          => (int) $validated['numero'],
            ];

            if ($request->filled('password')) {
                $dadosCliente['password'] = Hash::make($request->password);
            }

            $cliente->update($dadosCliente);

            // Sincroniza o usuário principal na tabela 'users'
            if ($cliente->user) {
                $dadosUser = [
                    'name'  => $validated['nome'],
                    'email' => $validated['email'],
                ];
                if ($request->filled('password')) {
                    $dadosUser['password'] = Hash::make($request->password);
                }
                $cliente->user->update($dadosUser);
            }
        });

        return redirect()->route('clientes.index')->with('success', 'Perfil do cliente atualizado!');
    }

    public function destroy(Cliente $cliente)
    {
        DB::transaction(function () use ($cliente) {
            if ($cliente->user) {
                $cliente->user->delete(); // Apaga o User e via cascade remove o Cliente
            } else {
                $cliente->delete();
            }
        });

        return redirect()->route('clientes.index')->with('success', 'Cliente removido com sucesso!');
    }
}