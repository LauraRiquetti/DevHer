<?php

namespace App\Http\Controllers;

// Importação da Model Avaliacao e da classe Request
use App\Models\Avaliacao;
use Illuminate\Http\Request;

class AvaliacaoController extends Controller
{
    /**
     * Armazena uma nova avaliação no banco de dados
     */
    public function store(Request $request)
    {
        // 1. Valida os dados enviados pelo formulário
        $request->validate([
            'vendedora_id' => 'required|exists:vendedoras,id', // Exige um ID existente na tabela vendedoras
            'comentario'   => 'required|string|max:1000',      // Texto obrigatório com no máximo 1000 caracteres
        ]);

        // 2. Salva a avaliação no banco de dados
        Avaliacao::create([
            'user_id'      => auth()->id(), // Pega o ID da usuária autenticada
            'vendedora_id' => $request->vendedora_id, // ID da vendedora avaliada
            'comentario'   => $request->comentario,   // Texto do comentário
            'nota'         => 5, // Nota padrão até você colocar um seletor de estrelas
        ]);

        // 3. Recarrega a página anterior exibindo a mensagem de sucesso
        return redirect()->back()->with('success', 'Avaliação enviada com sucesso!');
    }
}