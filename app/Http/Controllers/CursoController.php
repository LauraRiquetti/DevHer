<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    public function index()
    {
        $cursos = Curso::orderByDesc('id')->get();
        return view('cursos.index', compact('cursos'));
    }

    public function create()
    {
        return view('cursos.create');
    }

    public function store(Request $request)
    {
        // 1. Valida os dados de acordo com as colunas da migration
        $dadosValidados = $request->validate([
            'nome'      => 'required|string|max:255',
            'preco'     => 'required|numeric|min:0',
            'descricao' => 'nullable|string',
            'imagem'    => 'nullable|string', // Caso envie a URL ou caminho da imagem
            'categoria'    => 'nullable|string',
            'user_id'   => 'required|exists:users,id', // Ajustado para a tabela padrão 'users' do Laravel
        ], [
            'user_id.exists'  => 'O responsável selecionado não foi encontrado.',
        ]);

        // 2. Cria o projeto
        Curso::create($dadosValidados);

        return redirect()->route('cursos.index')
            ->with('success', 'Curso cadastrado com sucesso!');
    }   

    public function update(Request $request, Curso $curso)
    {
        // 1. Valida os dados que podem ser atualizados
        $dadosValidados = $request->validate([
            'nome'      => 'required|string|max:255',
            'preco'     => 'required|numeric|min:0',
            'descricao' => 'nullable|string',
            'imagem'    => 'nullable|string',
            'categoria'    => 'nullable|string',
            'user_id'   => 'required|exists:users,id',
        ]);

        $curso->update($dadosValidados);

        return redirect()->route('cursos.index')
            ->with('success', 'Curso atualizado com sucesso!');
    }

    public function destroy(Curso $curso) 
    {
        $curso->delete();
        
        return redirect()->route('cursos.index')
            ->with('success', 'Curso excluído com sucesso!');
    }
    public function porCategoria($categoria)
    {
        // Busca os cursos onde a coluna 'categoria' bate com a URL
        $cursos = Curso::where('categoria', $categoria)->get();
        
        // Vamos usar a mesma view (loja.home), mas agora passando apenas os cursos filtrados e o nome da categoria atual
        return view('loja.home', compact('cursos', 'categoria'));
    }
}