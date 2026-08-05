<?php

namespace App\Http\Controllers;

use App\Models\Topico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RespostaController extends Controller
{
    /**
     * Salva uma resposta (mensagem do bate-papo) dentro de um tópico
     */
    public function store(Request $request, Topico $topico)
    {
        $dados = $request->validate([
            'mensagem' => 'required|string|max:3000',
        ]);

        $topico->respostas()->create([
            'user_id'  => Auth::id(),
            'mensagem' => $dados['mensagem'],
        ]);

        return redirect()->route('topicos.show', $topico)
            ->with('sucesso', 'Resposta enviada!');
    }
}