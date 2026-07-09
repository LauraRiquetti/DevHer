<?php

namespace App\Http\Controllers;

use App\Models\Projeto;
use Illuminate\Http\Request;

class ProjetoController extends Controller
{
    public function index()
    {
        $projetos = Projeto::orderByDesc('id')->get();
        return view('projetos.index', compact('projetos'));
    }

    public function create()
    {
        return view('projetos.create');
    }

    public function store(Request $request)
    {
        // 1. Valida os dados de acordo com as colunas da migration
        $dadosValidados = $request->validate([
            'nome'      => 'required|string|max:255',
            'preco'     => 'required|numeric|min:0',
            'descricao' => 'nullable|string',
            'status'    => 'required|in:disponivel,vendido',
            'imagem'    => 'nullable|string', // Caso envie a URL ou caminho da imagem
            'user_id'   => 'required|exists:users,id', // Ajustado para a tabela padrão 'users' do Laravel
        ], [
            'status.in'       => 'O status selecionado é inválido.',
            'user_id.exists'  => 'O responsável selecionado não foi encontrado.',
        ]);

        // 2. Cria o projeto
        Projeto::create($dadosValidados);

        return redirect()->route('projetos.index')
            ->with('success', 'Projeto cadastrado com sucesso!');
    }   

    public function update(Request $request, Projeto $projeto)
    {
        // 1. Valida os dados que podem ser atualizados
        $dadosValidados = $request->validate([
            'nome'      => 'required|string|max:255',
            'preco'     => 'required|numeric|min:0',
            'descricao' => 'nullable|string',
            'status'    => 'required|in:disponivel,vendido',
            'imagem'    => 'nullable|string',
            'user_id'   => 'required|exists:users,id',
        ]);

        // 2. Corrigido o erro de digitação ($prejeto -> $projeto)
        $projeto->update($dadosValidados);

        return redirect()->route('projetos.index')
            ->with('success', 'Projeto atualizado com sucesso!');
    }

    public function destroy(Projeto $projeto)
    {
        $projeto->delete();
        
        return redirect()->route('projetos.index')
            ->with('success', 'Projeto excluído com sucesso!');
    }
    
    /* Filtro para buscar pelo status de disponivel */
    public function porStatus($status)
    {
        // Valida se o status buscado na URL é um dos permitidos
        if (!in_array($status, ['disponivel', 'vendido'])) {
            abort(404);
        }

        $projetos = Projeto::where('status', $status)->get();
        
        return view('projetos.index', compact('projetos', 'status'));
    }
}