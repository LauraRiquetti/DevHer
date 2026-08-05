<?php

namespace App\Http\Controllers;

use App\Models\Comunidade;

class ComunidadeController extends Controller
{
    /**
     * Lista todas as comunidades disponíveis (a página "Comunidade" do menu)
     */
    public function index()
    {
        // withCount evita ter que contar os tópicos manualmente na view
        $comunidades = Comunidade::withCount('topicos')->orderBy('nome')->get();

        return view('comunidades.index', compact('comunidades'));
    }

    /**
     * Mostra o fórum de uma comunidade específica: a lista de tópicos/discussões
     */
    public function show(Comunidade $comunidade)
    {
        $topicos = $comunidade->topicos()
            ->with('user')
            ->withCount('respostas')
            ->paginate(10);

        return view('comunidades.show', compact('comunidade', 'topicos'));
    }
}