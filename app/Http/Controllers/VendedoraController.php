<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vendedora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class VendedoraController extends Controller
{
    public function buscarCep($cep)
    {
        $cepLimpo = preg_replace('/[^0-9]/', '', $cep);
        $response = Http::get("https://viacep.com.br/ws/{$cepLimpo}/json/");

        return response()->json($response->json());
    }

    public function index()
    {
        $vendedoras = Vendedora::with('user')->orderByDesc('id')->get();

        return view('vendedoras.index', compact('vendedoras'));
    }

    public function create()
    {
        return view('vendedoras.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome'            => 'required|string|max:255',
            'email'           => 'required|email|unique:users,email|unique:vendedoras,email',
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

        // Transação para manter integridade
        DB::transaction(function () use ($validated, $cpfLimpo, $cepLimpo) {
            $user = User::create([
                'name'     => $validated['nome'],
                'email'    => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role'     => 'vendedora',
            ]);

            Vendedora::create([
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
                'role'            => 'vendedora',
            ]);
        });

        return redirect('/login')->with('success', 'Conta de criadora criada! Agora faça login.');
    }

    public function update(Request $request, Vendedora $vendedora)
    {
        $validated = $request->validate([
            'nome'            => 'required|string|max:255',
            'email'           => 'required|email|unique:vendedoras,email,' . $vendedora->id,
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

        DB::transaction(function () use ($request, $vendedora, $validated, $cpfLimpo, $cepLimpo) {
            $dadosVendedora = [
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
                $dadosVendedora['password'] = Hash::make($request->password);
            }

            $vendedora->update($dadosVendedora);

            // Sincroniza dados na tabela principal 'users'
            if ($vendedora->user) {
                $dadosUser = [
                    'name'  => $validated['nome'],
                    'email' => $validated['email'],
                ];
                if ($request->filled('password')) {
                    $dadosUser['password'] = Hash::make($request->password);
                }
                $vendedora->user->update($dadosUser);
            }
        });

        return redirect()->route('vendedoras.index')->with('success', 'Perfil da vendedora atualizado!');
    }

    public function destroy(Vendedora $vendedora)
    {
        DB::transaction(function () use ($vendedora) {
            if ($vendedora->user) {
                $vendedora->user->delete(); // Apaga o User e ativa deleção em cascata
            } else {
                $vendedora->delete();
            }
        });

        return redirect()->route('vendedoras.index')->with('success', 'Vendedora removida com sucesso!');
    }
}