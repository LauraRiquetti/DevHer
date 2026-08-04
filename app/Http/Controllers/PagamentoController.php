<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; 
use Illuminate\Support\Facades\Auth;
use App\Models\Pedido; 

class PagamentoController extends Controller
{
    public function processar(Request $request)
    {
        // 1. Garante que a usuária está logada
        if (!Auth::check()) {
            return redirect()->route('login')->with('erro', 'Você precisa estar logada para finalizar a compra.');
        }

        $carrinho = session()->get('carrinho', []);

        if (empty($carrinho)) {
            return redirect()->route('carrinho.index')->with('erro', 'Seu carrinho está vazio.');
        }

        // 2. Monta os itens tratando o formato do preço
        $items = [];
        $valorTotal = 0; 

        foreach ($carrinho as $item) {
            // Trata o preço limpando 'R$', espaços e trocando vírgula por ponto
            $precoLimpo = $item['preco'];
            if (is_string($precoLimpo)) {
                $precoLimpo = str_replace(['R$', ' ', '.'], '', $precoLimpo);
                $precoLimpo = str_replace(',', '.', $precoLimpo);
            }
            $precoFloat = (float) $precoLimpo;

            $items[] = [
                'id'          => (string) $item['id'],
                'title'       => '[' . strtoupper($item['tipo']) . '] ' . $item['nome'],
                'quantity'    => (int) $item['quantidade'],
                'unit_price'  => $precoFloat,
                'currency_id' => 'BRL'
            ];
            
            $valorTotal += $precoFloat * (int) $item['quantidade'];
        }

        // 3. Salva o Pedido no Banco
        $pedido = Pedido::create([
            'user_id'     => Auth::id(),
            'valor_total' => $valorTotal,
            'status'      => 'pendente',
            'itens'       => json_encode($carrinho) 
        ]);

        // 4. Prepara requisição HTTP
        $token = config('services.mercadopago.access_token');
        $requisicao = Http::withToken($token);

        if (app()->environment('local')) {
            $requisicao->withoutVerifying();
        }

        // 5. Chamada para a API do Mercado Pago
        $response = $requisicao->post('https://api.mercadopago.com/checkout/preferences', [
            'items' => $items,
            'external_reference' => (string) $pedido->id, 
            'back_urls' => [
                'success' => route('pagamento.sucesso'),
                'failure' => route('pagamento.falha'), 
                'pending' => route('pagamento.pendente'), 
            ],
            // 'auto_return' => 'approved', // Desativado para evitar bloqueio em localhost sem HTTPS
        ]);

        // 6. Resposta com Sucesso
        if ($response->successful()) {
            $preference = $response->json();
            $pedido->update(['transacao_id' => $preference['id']]);
            
            $linkPagamento = $preference['sandbox_init_point'] ?? $preference['init_point'];
            return redirect()->away($linkPagamento);
        }
        
        // 7. Se falhar, mostra o erro detalhado para diagnóstico
        $pedido->delete();
        
        dd([
            'mensagem' => 'O Mercado Pago recusou a requisição.',
            'status_http' => $response->status(),
            'resposta_api' => $response->json(),
            'token_usado' => $token ? 'Token Presente' : 'TOKEN AUSENTE OU NULO! Verifique config/services.php'
        ]);
    }

    public function sucesso(Request $request)
    {
        $pedidoId = $request->input('external_reference');

        if ($pedidoId) {
            $pedido = Pedido::find($pedidoId);
            if ($pedido) {
                $pedido->update(['status' => 'aprovado']);
            }
        }

        session()->forget('carrinho');
        return redirect()->route('meus-pedidos')->with('success', 'Pagamento aprovado! Seu pedido foi liberado.');
    }

    public function falha(Request $request)
    {
        return redirect()->route('carrinho.index')->with('erro', 'O pagamento foi recusado. Tente novamente.');
    }

    public function pendente(Request $request)
    {
        session()->forget('carrinho');
        return redirect()->route('meus-pedidos')->with('success', 'Pedido gerado! Aguardando o pagamento.');
    }
}