@extends('layouts.app') {{-- Substitua pelo layout padrão da sua aplicação se for diferente --}}

@section('content')
<div class="container my-5">
    <h2 class="mb-4">Seu Carrinho de Compras</h2>

    {{-- Exibição de mensagens de sucesso ou erro --}}
    @if (session('sucesso'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('sucesso') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
        </div>
    @endif

    @if (session('erro'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('erro') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
        </div>
    @endif

    {{-- Verificação: Carrinho Vazio --}}
    @if(empty($carrinho))
        <div class="text-center py-5 bg-light rounded shadow-sm">
            <h4 class="text-muted">Seu carrinho está vazio no momento.</h4>
            <p class="text-secondary mb-4">Navegue pelos cursos e projetos disponíveis para começar a comprar!</p>
            <a href="{{ url('/') }}" class="btn btn-primary">
                Voltar para a Loja
            </a>
        </div>
    @else
        <div class="row">
            {{-- Lista de Itens do Carrinho --}}
            <div class="col-lg-8 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tipo</th>
                                        <th>Item</th>
                                        <th>Preço Unitário</th>
                                        <th>Qtd</th>
                                        <th>Subtotal</th>
                                        <th class="text-center">Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($carrinho as $chave => $item)
                                        <tr>
                                            {{-- Distinção entre Curso e Projeto --}}
                                            <td>
                                                @if($item['tipo'] === 'curso')
                                                    <span class="badge bg-info text-dark">Curso</span>
                                                @else
                                                    <span class="badge bg-purple text-white" style="background-color: #6f42c1;">Projeto</span>
                                                @endif
                                            </td>

                                            <td class="fw-bold">{{ $item['nome'] }}</td>

                                            <td>R$ {{ number_format($item['valor'], 2, ',', '.') }}</td>

                                            <td>{{ $item['quantidade'] }}</td>

                                            <td class="fw-bold text-success">
                                                R$ {{ number_format($item['valor'] * $item['quantidade'], 2, ',', '.') }}
                                            </td>

                                            {{-- Botão de Remoção Individual --}}
                                            <td class="text-center">
                                                <form action="{{ route('carrinho.remover', $chave) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm" title="Remover item">
                                                        Remover
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Ações Secundárias --}}
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <a href="{{ url('/') }}" class="btn btn-outline-secondary">
                        Continuar Comprando
                    </a>

                    <form action="{{ route('carrinho.limpar') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-warning btn-sm" onclick="return confirm('Tem certeza que deseja esvaziar o carrinho?')">
                            Esvaziar Carrinho
                        </button>
                    </form>
                </div>
            </div>

            {{-- Resumo e Checkout --}}
            <div class="col-lg-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Resumo do Pedido</h5>
                        <hr>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span>Itens selecionados:</span>
                            <span>{{ count($carrinho) }}</span>
                        </div>

                        <div class="d-flex justify-content-between fw-bold fs-4 my-3">
                            <span>Total:</span>
                            <span class="text-success">R$ {{ number_format($total, 2, ',', '.') }}</span>
                        </div>

                        <form action="{{ route('pagamento.processar') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success btn-lg w-100 fw-bold mt-2">
                                Finalizar Compra com Mercado Pago
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection