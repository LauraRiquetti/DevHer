@extends('Layouts.app')

@section('title', 'Carrinho')

@section('content')

<section class="page-head">
    <div class="wrap">
        <span class="eyebrow">Sua sacola</span>
        <h1>Carrinho</h1>
        <p>Revise os cursos escolhidos antes de finalizar a compra.</p>
    </div>
</section>

<section style="padding:48px 0 100px;">
    <div class="wrap" style="display:grid;grid-template-columns:1.6fr 1fr;gap:40px;align-items:start;">

        @if (session('success'))
            <div class="alert alert-success" style="grid-column:1 / -1;">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-error" style="grid-column:1 / -1;">{{ $errors->first() }}</div>
        @endif

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Curso</th>
                        <th>Qtd.</th>
                        <th>Preço</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($itens as $item)
                        <tr>
                            <td>{{ $item['titulo'] }}</td>
                            <td>{{ $item['quantidade'] }}</td>
                            <td>R$ {{ number_format($item['preco'] * $item['quantidade'], 2, ',', '.') }}</td>
                            <td>
                                <form method="POST" action="{{ route('carrinho.remove', $item['id']) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Remover</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" style="color:var(--muted);">Seu carrinho está vazio.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card">
            <div class="panel-title"><h3>Resumo</h3></div>
            <div style="display:flex;justify-content:space-between;font-family:var(--display);font-size:20px;border-top:1px solid var(--line);padding-top:16px;margin-bottom:22px;">
                <span>Total</span><span>R$ {{ number_format($total, 2, ',', '.') }}</span>
            </div>

            <form method="POST" action="{{ route('carrinho.checkout') }}">
                @csrf
                <div class="field">
                    <label for="pagamento">Forma de pagamento</label>
                    <select name="pagamento" id="pagamento">
                        <option value="cartao">Cartão de crédito</option>
                        <option value="pix">Pix</option>
                        <option value="boleto">Boleto</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-block" {{ empty($itens) ? 'disabled' : '' }}>Finalizar compra</button>
            </form>
        </div>
    </div>
</section>
@endsection