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
        // Valida os dados de acordo com as colunas da migration.
        // Adicionei "link_material" (opcional) para os cursos gratuitos
        // poderem ter um acesso direto ao conteúdo (vídeo/PDF/etc).
        $dadosValidados = $request->validate([
            'nome'          => 'required|string|max:255',
            'preco'         => 'required|numeric|min:0',
            'descricao'     => 'nullable|string',
            'imagem'        => 'nullable|string',
            'categoria'     => 'nullable|string',
            'link_material' => 'nullable|url',
        ]);

        // O "autor" do curso é a vendedora logada na sessão (não pedimos
        // isso no formulário — é preenchido automaticamente aqui).
        $dadosValidados['user_id'] = session('vendedora_id');

        if (!$dadosValidados['user_id']) {
            return back()
                ->withErrors(['nome' => 'Você precisa estar logada como vendedora para publicar um curso.'])
                ->withInput();
        }

        Curso::create($dadosValidados);

        return redirect()->route('cursos.index')
            ->with('success', 'Curso cadastrado com sucesso!');
    }

    public function update(Request $request, Curso $curso)
    {
        $dadosValidados = $request->validate([
            'nome'          => 'required|string|max:255',
            'preco'         => 'required|numeric|min:0',
            'descricao'     => 'nullable|string',
            'imagem'        => 'nullable|string',
            'categoria'     => 'nullable|string',
            'link_material' => 'nullable|url',
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
        $cursos = Curso::where('categoria', $categoria)->get();

        return view('loja.home', compact('cursos', 'categoria'));
    }
}