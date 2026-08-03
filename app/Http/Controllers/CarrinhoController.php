<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Projeto;
use Illuminate\Http\Request;

class CarrinhoController extends Controller
{
    /**
     * Adiciona um Curso ou Projeto ao carrinho
     */
    public function adicionar($tipo, $id)
    {
        // 1. Busca o item no Model correspondente
        if ($tipo === 'curso') {
            $item = Curso::findOrFail($id);
        } elseif ($tipo === 'projeto') {
            $item = Projeto::findOrFail($id);
        } else {
            return redirect()->back()->with('erro', 'Tipo de produto inválido.');
        }

        // 2. Cria uma chave única no carrinho (ex: "curso_1" ou "projeto_3")
        $chave = $tipo . '_' . $id;

        $carrinho = session()->get('carrinho', []);

        // 3. Adiciona ou atualiza no carrinho
        if (isset($carrinho[$chave])) {
            // Cursos geralmente não precisam de quantidade > 1 por conta
            if ($tipo !== 'curso') {
                $carrinho[$chave]['quantidade']++;
            }
        } else {
            $carrinho[$chave] = [
                'id'         => $item->id,
                'tipo'       => $tipo,
                'nome'       => $item->nome, 
                'preco'      => $item->preco, 
                'quantidade' => 1,
            ];
        }

        session()->put('carrinho', $carrinho);

        return redirect()->back()->with('sucesso', ucfirst($tipo) . ' adicionado ao carrinho!');
    }

    /**
     * Exibe a tela do carrinho
     */
    public function index()
    {
        $carrinho = session()->get('carrinho', []);

        // Calcula o valor total do carrinho
        $total = array_reduce($carrinho, function ($acc, $item) {
            return $acc + ($item['preco'] * $item['quantidade']);
        }, 0);

        return view('loja.carrinho', compact('carrinho', 'total'));
    }

    /**
     * Remove um item específico do carrinho
     */
    public function remover($chave)
    {
        $carrinho = session()->get('carrinho', []);

        if (isset($carrinho[$chave])) {
            unset($carrinho[$chave]);
            session()->put('carrinho', $carrinho);
        }

        return redirect()->back()->with('sucesso', 'Item removido do carrinho.');
    }

    /**
     * Esvazia todo o carrinho
     */
    public function limpar()
    {
        session()->forget('carrinho');
        return redirect()->back()->with('sucesso', 'Carrinho limpo.');
    }
}