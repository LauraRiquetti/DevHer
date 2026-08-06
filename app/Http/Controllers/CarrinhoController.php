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
            if ($tipo !== 'curso') {
                $carrinho[$chave]['quantidade']++;
            }
        } else {
            // Busca o valor tratando possíveis variações nos nomes das colunas
            $precoItem = $item->preco ?? $item->valor ?? 0;
            $nomeItem  = $item->nome ?? $item->titulo ?? 'Item sem nome';

            $carrinho[$chave] = [
                'id'         => $item->id,
                'tipo'       => $tipo,
                'nome'       => $nomeItem,
                'preco'      => $precoItem, 
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

        // Calcula o valor total tratando os formatos de preço
        $total = array_reduce($carrinho, function ($acc, $item) {
            $preco = $this->converterPrecoParaFloat($item['preco'] ?? $item['valor'] ?? 0);
            $qty   = (int) ($item['quantidade'] ?? 1);
            return $acc + ($preco * $qty);
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

    /**
     * Função auxiliar de conversão de preço
     */
    private function converterPrecoParaFloat($preco): float
    {
        if (empty($preco)) return 0.0;

        if (is_numeric($preco) && !is_string($preco)) {
            return (float) $preco;
        }

        $precoStr = str_replace(['R$', '$', ' '], '', (string) $preco);

        if (str_contains($precoStr, ',')) {
            $precoStr = str_replace('.', '', $precoStr);
            $precoStr = str_replace(',', '.', $precoStr);
        }

        return (float) $precoStr;
    }
}