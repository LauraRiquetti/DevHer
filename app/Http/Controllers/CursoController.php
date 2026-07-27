<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CursoController extends Controller
{
    public function index()
    {
        $cursos = Curso::orderByDesc('id')->get();

        $idadeUsuaria = null;
        if (Auth::check() && Auth::user()->data_nascimento) {
            $idadeUsuaria = Carbon::parse(Auth::user()->data_nascimento)->age;
        }

        return view('cursos.index', compact('cursos', 'idadeUsuaria'));
    }

    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Você precisa estar logada para cadastrar um curso.');
        }

        if (Auth::user()->tipo !== 'vendedora') {
            abort(403, 'Acesso não autorizado. Apenas usuárias do tipo vendedora podem publicar cursos.');
        }

        return view('cursos.create');
    }

    public function store(Request $request)
    {
        if (!Auth::check() || Auth::user()->tipo !== 'vendedora') {
            abort(403, 'Apenas vendedoras podem criar cursos.');
        }

        $dadosValidados = $request->validate([
            'nome'      => 'required|string|max:255',
            'preco'     => 'required|numeric|min:0',
            'descricao' => 'nullable|string',
            'imagem'    => 'nullable|string',
            'categoria' => 'nullable|string',
        ]);

        $dadosValidados['user_id'] = Auth::id();

        Curso::create($dadosValidados);

        return redirect()->route('cursos.index')
            ->with('success', 'Curso cadastrado com sucesso!');
    }

    public function update(Request $request, Curso $curso)
    {
        if (!Auth::check() || Auth::user()->id !== $curso->user_id) {
            abort(403, 'Você não tem permissão para alterar este curso.');
        }

        $dadosValidados = $request->validate([
            'nome'      => 'required|string|max:255',
            'preco'     => 'required|numeric|min:0',
            'descricao' => 'nullable|string',
            'imagem'    => 'nullable|string',
            'categoria' => 'nullable|string',
        ]);

        $curso->update($dadosValidados);

        return redirect()->route('cursos.index')
            ->with('success', 'Curso atualizado com sucesso!');
    }

    public function destroy(Curso $curso) 
    {
        if (!Auth::check() || Auth::user()->id !== $curso->user_id) {
            abort(403, 'Você não tem permissão para excluir este curso.');
        }

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