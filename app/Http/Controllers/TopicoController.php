<?php

namespace App\Http\Controllers;

use App\Models\Comunidade;
use App\Models\Topico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TopicoController extends Controller
{
    /**
     * Formulário para abrir um novo tópico dentro de uma comunidade
     */
    public function create(Comunidade $comunidade)
    {
        return view('topicos.create', compact('comunidade'));
    }

    /**
     * Salva um novo tópico
     */
    public function store(Request $request, Comunidade $comunidade)
    {
        $dados = $request->validate([
            'titulo'   => 'required|string|max:255',
            'mensagem' => 'required|string|max:5000',
        ]);

        $topico = $comunidade->topicos()->create([
            'user_id'  => Auth::id(),
            'titulo'   => $dados['titulo'],
            'mensagem' => $dados['mensagem'],
        ]);

        return redirect()->route('topicos.show', $topico)
            ->with('sucesso', 'Tópico criado com sucesso!');
    }

    /**
     * Mostra um tópico e todas as respostas (o bate-papo em si)
     */
    public function show(Topico $topico)
    {
        // Carrega quem abriu o tópico, a comunidade e as respostas já com autoras
        $topico->load(['user', 'comunidade', 'respostas.user']);

        return view('topicos.show', compact('topico'));
    }
}