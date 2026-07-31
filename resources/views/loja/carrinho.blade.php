@extends('layouts.app') {{-- Substitua pelo layout padrão da sua aplicação se for diferente --}}

@section('content')
{{-- Container flexível com altura mínima para garantir que ocupe a tela --}}
<div class="container d-flex flex-column" style="min-height: 80vh; padding-top: 3rem; padding-bottom: 3rem;">
    
    {{-- Título Centralizado --}}
    <div class="w-100 text-center mb-4">
        <div class="d-inline-flex justify-content-center align-items-center gap-3">
            <i class="bi bi-cart4 fs-1" style="color: var(--pink-light, #e83e8c);"></i>
            <h2 class="mb-0 fw-bold">Seu Carrinho de Compras</h2>
        </div>
    </div>

    {{-- Exibição de mensagens de sucesso ou erro --}}
    @if (session('sucesso'))
        <div class="row justify-content-center w-100 mx-0 mb-4">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="alert alert-success alert-dismissible fade show shadow-sm text-center" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('sucesso') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                </div>
            </div>
        </div>
    @endif

    @if (session('erro'))
        <div class="row justify-content-center w-100 mx-0 mb-4">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="alert alert-danger alert-dismissible fade show shadow-sm text-center" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('erro') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                </div>
            </div>
        </div>
    @endif

    {{-- Verificação: Carrinho Vazio no Centro EXATO da Tela --}}
    @if(empty($carrinho))
        {{-- O flex-grow-1 faz essa div ocupar todo o espaço que sobrou, centralizando na vertical e horizontal --}}
        <div class="flex-grow-1 d-flex flex-column justify-content-center align-items-center text-center w-100">
            <i class="bi bi-cart-x text-muted mb-4" style="font-size: 6rem;"></i>
            <h3 class="fw-bold mb-3">Seu carrinho está vazio no momento.</h3>
            <p class="text-secondary mb-5 fs-5">Navegue pelos cursos e projetos disponíveis para começar a comprar!</p>
            <a href="{{ url('/') }}" class="btn text-white fw-bold px-5 py-3 fs-5 shadow-sm" style="background-color: var(--pink-light, #e83e8c); border-radius: 8px;">
                <i class="bi bi-arrow-left me-2"></i> Voltar para a Loja
            </a>
        </div>
    @else
        {{-- Layout quando há itens no carrinho --}}
        <div class="row g-4 w-100 mx-0 mt-2">
            {{-- Lista de Itens do Carrinho --}}
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0 table-hover text-center">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4 text-start">Tipo</th>
                                        <th class="text-start">Item</th>
                                        <th>Preço Unitário</th>
                                        <th>Qtd</th>
                                        <th>Subtotal</th>
                                        <th class="pe-4">Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($carrinho as $chave => $item)
                                        <tr>
                                            {{-- Distinção entre Curso e Projeto --}}
                                            <td class="ps-4 text-start">
                                                @if($item['tipo'] === 'curso')
                                                    <span class="badge rounded-pill bg-info text-dark fw-bold">Curso</span>
                                                @else
                                                    <span class="badge rounded-pill text-white fw-bold" style="background-color: #6f42c1;">Projeto</span>
                                                @endif
                                            </td>

                                            <td class="fw-bold text-dark text-start">{{ $item['nome'] }}</td>

                                            <td class="text-muted">R$ {{ number_format($item['valor'], 2, ',', '.') }}</td>

                                            <td class="fw-semibold">{{ $item['quantidade'] }}</td>

                                            <td class="fw-bold text-success">
                                                R$ {{ number_format($item['valor'] * $item['quantidade'], 2, ',', '.') }}
                                            </td>

                                            {{-- Botão de Remoção Individual --}}
                                            <td class="pe-4">
                                                <form action="{{ route('carrinho.remover', $chave) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-circle" title="Remover item" style="width: 32px; height: 32px; padding: 0;">
                                                        <i class="bi bi-trash3-fill"></i>
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
                <div class="d-flex justify-content-between align-items-center mt-4 px-2">
                    <a href="{{ url('/') }}" class="btn btn-outline-light fw-semibold" style="border-radius: 8px;">
                        <i class="bi bi-arrow-left me-1"></i> Continuar Comprando
                    </a>

                    <form action="{{ route('carrinho.limpar') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-link text-danger text-decoration-none fw-semibold" onclick="return confirm('Tem certeza que deseja esvaziar o carrinho?')">
                            Esvaziar Carrinho
                        </button>
                    </form>
                </div>
            </div>

            {{-- Resumo e Checkout --}}
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 rounded-4 sticky-top" style="top: 20px;">
                    <div class="card-body p-4 text-center">
                        <h5 class="card-title fw-bold mb-3">Resumo do Pedido</h5>
                        <hr class="text-muted mb-4">
                        
                        <div class="d-flex justify-content-between mb-3 text-secondary">
                            <span>Itens selecionados:</span>
                            <span class="fw-bold text-dark">{{ count($carrinho) }}</span>
                        </div>

                        <div class="d-flex justify-content-between fw-bold fs-4 mb-4">
                            <span class="text-dark">Total:</span>
                            <span style="color: var(--pink-light, #e83e8c);">R$ {{ number_format($total, 2, ',', '.') }}</span>
                        </div>

                        {{-- ALERTA DE LOGIN PARA USUÁRIOS DESLOGADOS --}}
                        @guest
                            <a href="{{ route('login') }}" class="btn btn-success btn-lg w-100 fw-bold mt-2">
                                Faça login na sua conta para fazer compras
                            </a>
                        @else
                            {{-- FORMULÁRIO DE CHECKOUT PARA USUÁRIOS LOGADOS --}}
                            <form action="{{ route('pagamento.processar') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success btn-lg w-100 fw-bold mt-2">
                                    Finalizar Compra com Mercado Pago
                                </button>
                            </form>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection