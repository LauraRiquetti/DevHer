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

        // 2. Monta os itens tratando o preço com precisão
        $items = [];
        $valorTotal = 0; 
        $user = Auth::user();

        foreach ($carrinho as $item) {
            // Aceita 'preco' ou 'valor' vindo da sessão
            $precoBruto = $item['preco'] ?? $item['valor'] ?? 0;
            $precoFloat = $this->converterPrecoParaFloat($precoBruto);
            $quantidade = (int) ($item['quantidade'] ?? 1);

            // Ignora itens zerados/gratuitos (Mercado Pago exige unit_price > 0)
            if ($precoFloat <= 0) {
                continue;
            }

            $items[] = [
                'id'          => (string) $item['id'],
                'title'       => substr('[' . strtoupper($item['tipo'] ?? 'PRODUTO') . '] ' . ($item['nome'] ?? 'Item'), 0, 255),
                'quantity'    => $quantidade,
                'unit_price'  => (float) number_format($precoFloat, 2, '.', ''), // Formata 15.00
                'currency_id' => 'BRL'
            ];
            
            $valorTotal += $precoFloat * $quantidade;
        }

        // Se o carrinho só tinha itens inválidos ou zerados
        if (empty($items)) {
            return redirect()->route('carrinho.index')->with('erro', 'O carrinho não possui itens pagos válidos para processar o pagamento.');
        }

        // 3. Salva o Pedido no Banco
        $pedido = Pedido::create([
            'user_id'     => $user->id,
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

        // 5. Monta o Payload da Preferência
        $payload = [
            'items' => $items,
            'external_reference' => (string) $pedido->id,
            'payer' => [
                'name'  => $user->name ?? 'Cliente',
                'email' => $user->email,
            ],
        ];

        // Se NÃO estiver rodando em localhost, envia as back_urls
        $host = $request->getHost();
        $isLocalhost = in_array($host, ['localhost', '127.0.0.1']) 
                    || str_ends_with($host, '.test') 
                    || str_ends_with($host, '.local');

        if (!$isLocalhost) {
            $payload['back_urls'] = [
                'success' => route('pagamento.sucesso'),
                'failure' => route('pagamento.falha'), 
                'pending' => route('pagamento.pendente'), 
            ];
            $payload['auto_return'] = 'approved';
        }

        // 6. Chamada para a API do Mercado Pago
        $response = $requisicao->post('https://api.mercadopago.com/checkout/preferences', $payload);

        // 7. Resposta com Sucesso
        if ($response->successful()) {
            $preference = $response->json();
            $pedido->update(['transacao_id' => $preference['id']]);
            
            $linkPagamento = $preference['sandbox_init_point'] ?? $preference['init_point'];
            return redirect()->away($linkPagamento);
        }
        
        // 8. Diagnóstico de Erro (se ocorrer qualquer outro motivo)
        $pedido->delete();
        
        dd([
            'MOTIVO_EXATO'    => $response->json()['cause'] ?? $response->json()['message'] ?? 'Erro no Mercado Pago',
            'PAYLOAD_ENVIADO' => $payload,
            'RESPOSTA_API'    => $response->json()
        ]);
    }

    /**
     * Função auxiliar para converter preços para float puro
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