<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // <-- Importando o Cliente HTTP do Laravel

class PagamentoController extends Controller
{
    public function processar(Request $request)
    {
        $carrinho = session()->get('carrinho', []);

        if (empty($carrinho)) {
            return redirect()->route('carrinho.index')->with('erro', 'Seu carrinho está vazio.');
        }

        // 1. Monta os itens no formato exigido pela API
        $items = [];
        foreach ($carrinho as $item) {
            $items[] = [
                'id'          => (string) $item['id'],
                'title'       => '[' . strtoupper($item['tipo']) . '] ' . $item['nome'],
                'quantity'    => (int) $item['quantidade'],
                'unit_price'  => (float) $item['valor'],
                'currency_id' => 'BRL'
            ];
        }

        // 2. Faz a chamada direta para a API do Mercado Pago usando o token
        $response = Http::withToken(config('services.mercadopago.access_token'))
            ->post('https://api.mercadopago.com/checkout/preferences', [
                'items' => $items,
                /* Descomente e ajuste abaixo se quiser configurar as URLs de retorno após o pagamento:
                'back_urls' => [
                    'success' => route('home'), // Rota quando der certo
                    'failure' => route('home'), // Rota quando falhar
                    'pending' => route('home'), // Rota quando ficar pendente
                ],
                'auto_return' => 'approved',
                */
            ]);

        // 3. Verifica se a requisição deu certo
        if ($response->successful()) {
            $preference = $response->json();
            
            // Redireciona o usuário para o link de pagamento do Mercado Pago
            // Obs: Estamos usando sandbox_init_point para testes. Para produção, seria init_point
            $linkPagamento = $preference['sandbox_init_point'] ?? $preference['init_point'];
            
            return redirect()->away($linkPagamento);
        }

        // 4. Se a API do Mercado Pago recusar ou der erro
        return redirect()->route('carrinho.index')->with('erro', 'Falha ao conectar com o Mercado Pago. Verifique suas credenciais.');
    }
}