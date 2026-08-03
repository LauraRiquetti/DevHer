<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\Request;

class CarrinhoController extends Controller
{
    /**
     * Mostra os itens que estão no carrinho (guardado na sessão do navegador).
     */
    public function index()
    {
        $itens = session('carrinho', []);
        $total = collect($itens)->sum(fn ($item) => $item['preco'] * $item['quantidade']);

        return view('Carrinho.index', compact('itens', 'total'));
    }

    /**
     * Adiciona um curso ao carrinho (só cursos pagos precisam passar por
     * aqui — os gratuitos têm acesso direto pelo link_material).
     */
    public function add(Request $request)
    {
        $request->validate(['curso_id' => 'required|exists:cursos,id']);

        $curso = Curso::findOrFail($request->curso_id);

        $carrinho = session('carrinho', []);

        if (isset($carrinho[$curso->id])) {
            $carrinho[$curso->id]['quantidade']++;
        } else {
            $carrinho[$curso->id] = [
                'id'         => $curso->id,
                'titulo'     => $curso->nome,
                'preco'      => $curso->preco,
                'quantidade' => 1,
            ];
        }

        session(['carrinho' => $carrinho]);

        return back()->with('success', 'Curso adicionado ao carrinho!');
    }

    /**
     * Remove um item do carrinho.
     */
    public function remove($id)
    {
        $carrinho = session('carrinho', []);
        unset($carrinho[$id]);
        session(['carrinho' => $carrinho]);

        return back()->with('success', 'Item removido do carrinho.');
    }

    /**
     * Finaliza a compra. Por enquanto só limpa o carrinho — é aqui que
     * depois entra a integração de verdade com um gateway de pagamento
     * (Stripe, Mercado Pago, etc). Deixei o comentário no lugar exato.
     */
    public function checkout(Request $request)
    {
        if (empty(session('carrinho'))) {
            return back()->withErrors(['carrinho' => 'Seu carrinho está vazio.']);
        }

        // TODO: aqui entra a chamada real ao gateway de pagamento.
        // Por enquanto simulamos a aprovação e limpamos o carrinho.
        session()->forget('carrinho');

        return redirect()->route('carrinho.sucesso');
    }
}