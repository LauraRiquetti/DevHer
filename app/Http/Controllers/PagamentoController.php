<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;

class PagamentoController extends Controller
{
    public function processar(Request $request)
    {
        $carrinho = session()->get('carrinho', []);

        if (empty($carrinho)) {
            return redirect()->route('carrinho.index')->with('erro', 'Seu carrinho está vazio.');
        }

        MercadoPagoConfig::setAccessToken(config('services.mercadopago.access_token'));

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

        $client = new PreferenceClient();
        
        try {
            $preference = $client->create([
                'items' => $items,
                'payer' => [
                    'name'  => auth()->user()->name ?? 'Cliente',
                    'email' => auth()->user()->email ?? 'cliente@email.com',
                ],
                'back_urls' => [
                    'success' => route('pagamento.sucesso'),
                    'failure' => route('pagamento.falha'),
                    'pending' => route('pagamento.pendente'),
                ],
                'auto_return' => 'approved',
            ]);

            return redirect($preference->sandbox_init_point ?? $preference->init_point);

        } catch (\Exception $e) {
            return redirect()->back()->with('erro', 'Erro ao conectar ao Mercado Pago: ' . $e->getMessage());
        }
    }

    public function sucesso(Request $request)
    {
        session()->forget('carrinho');
        return view('loja.sucesso');
    }

    public function falha()
    {
        return redirect()->route('carrinho.index')->with('erro', 'O pagamento foi recusado ou cancelado.');
    }

    public function pendente()
    {
        return view('loja.sucesso')->with('mensagem', 'Seu pagamento está em análise ou aguardando aprovação.');
    }
}