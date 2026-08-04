@extends('layouts.app')

@section('title', 'Marketplace de Projetos')

@section('content')

<section class="page-head">
    <div class="glow glow-1" style="top:-260px;"></div>
    <div class="wrap">
        <span class="eyebrow">Marketplace</span>
        <h1>Projetos publicados pela comunidade</h1>
        <p>Filtre por status ou busca, veja quem criou e adquira o projeto.</p>
    </div>
</section>

<section style="padding:48px 0 100px;">
    <div class="wrap">

        {{-- Mensagem de Sucesso (Corrigida para 'sucesso') --}}
        @if (session('sucesso'))
            <div style="padding: 12px 16px; background: #d4edda; color: #155724; border-radius: 6px; margin-bottom: 24px;">
                {{ session('sucesso') }}
            </div>
        @endif

        {{-- Toolbar de Filtro e Busca --}}
        <form method="GET" action="{{ route('projetos.index') }}" class="table-toolbar">
            <input type="text" name="busca" placeholder="Buscar projeto..." value="{{ request('busca') }}">
            
            <div style="display:flex; gap:10px; flex-wrap:wrap;">
                <label class="chip" style="cursor:pointer;">
                    <input type="radio" name="status" value="" style="display:none;"
                           {{ !request('status') ? 'checked' : '' }} onchange="this.form.submit()">
                    Todos
                </label>
                <label class="chip" style="cursor:pointer;">
                    <input type="radio" name="status" value="disponivel" style="display:none;"
                           {{ request('status') === 'disponivel' ? 'checked' : '' }} onchange="this.form.submit()">
                    Disponíveis
                </label>
                <label class="chip" style="cursor:pointer;">
                    <input type="radio" name="status" value="vendido" style="display:none;"
                           {{ request('status') === 'vendido' ? 'checked' : '' }} onchange="this.form.submit()">
                    Vendidos
                </label>
            </div>

            @auth
                {{-- Exibe o botão apenas se o usuário for 'vendedora' ou 'admin' --}}
                @if(in_array(auth()->user()->role, ['vendedora', 'admin']))
                    <a href="{{ route('projetos.create') }}" class="btn btn-primary btn-sm">+ Publicar projeto</a>
                @endif
            @endauth
        </form>

        {{-- Grid Dinâmica de Projetos do Banco --}}
        <div class="proj-grid" style="margin-top:32px;">
            @forelse ($projetos as $projeto)
                <div class="proj-card">
                    <div class="proj-thumb">
                        @if($projeto->imagem)
                            <img src="{{ $projeto->imagem }}" alt="{{ $projeto->nome }}" style="width:100%; height:100%; object-fit:cover;">
                        @endif
                    </div>

                    <span class="categoria" style="text-transform: capitalize;">{{ $projeto->status }}</span>
                    <h4>{{ $projeto->nome }}</h4>
                    <span class="autora">por {{ $projeto->user->name ?? 'Autor Desconhecido' }}</span>
                    <span class="price">R$ {{ number_format($projeto->preco, 2, ',', '.') }}</span>

                    @if($projeto->status === 'disponivel')
                        {{-- A CORREÇÃO ESTÁ NESTA LINHA ABAIXO: --}}
                        {{-- Adicionamos o array com 'tipo' => 'projeto' e o 'id' --}}
                        <form method="POST" action="{{ route('carrinho.add', ['tipo' => 'projeto', 'id' => $projeto->id]) }}" style="margin-top:12px;">
                            @csrf
                            <button type="submit" class="btn btn-ghost btn-sm btn-block">Adicionar ao carrinho</button>
                        </form>
                    @else
                        <button class="btn btn-ghost btn-sm btn-block" disabled style="opacity:0.6; cursor:not-allowed; margin-top:12px;">
                            Indisponível
                        </button>
                    @endif
                </div>
            @empty
                <p style="color:var(--muted);">Nenhum projeto encontrado para este filtro.</p>
            @endforelse
        </div>

        {{-- Paginação --}}
        {{-- A view padrão do Laravel usa classes do Tailwind (ex: sm:hidden) que não existem no
             CSS deste projeto. Sem Tailwind, os dois blocos de navegação (mobile e desktop) ficam
             visíveis ao mesmo tempo, e é por isso que "« Previous" / "Next »" apareciam soltos na tela.
             O bloco abaixo corrige isso via CSS, sem precisar de uma view de paginação separada. --}}
        <div class="proj-pagination" style="margin-top:32px;">
            {{ $projetos->links() }}
        </div>

        <style>
            /* Esconde a versão simplificada (mobile) da paginação padrão do Laravel,
               que só existia por causa da classe Tailwind "sm:hidden" (inerte sem Tailwind) */
            .proj-pagination nav[role="navigation"] > div[class*="sm:hidden"] {
                display: none !important;
            }

            /* Exibe sempre a versão completa (com números de página), que ficava
               escondida pela classe Tailwind "hidden" (também inerte sem Tailwind) */
            .proj-pagination nav[role="navigation"] > div.hidden {
                display: flex !important;
                align-items: center;
                justify-content: space-between;
                flex-wrap: wrap;
                gap: 16px;
            }

            .proj-pagination nav[role="navigation"] span.relative {
                display: inline-flex;
                align-items: center;
                gap: 4px;
                flex-wrap: wrap;
            }

            /* Texto "Showing X to Y of Z results" */
            .proj-pagination nav[role="navigation"] p {
                margin: 0;
                font-size: 0.85rem;
                color: var(--muted, #6b7280);
            }

            /* Botões de página (números e setas anterior/próxima) */
            .proj-pagination nav[role="navigation"] a,
            .proj-pagination nav[role="navigation"] span[aria-current] span {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                min-width: 38px;
                height: 38px;
                padding: 0 10px;
                border-radius: 8px;
                border: 1px solid rgba(255, 45, 135, 0.25);
                background: #fff;
                color: #1c1c1c;
                font-size: 0.85rem;
                font-weight: 600;
                text-decoration: none;
                transition: all .2s ease;
            }

            .proj-pagination nav[role="navigation"] a:hover {
                border-color: #FF2D87;
                color: #FF2D87;
                background: rgba(255, 45, 135, 0.06);
            }

            /* Página atual, destacada em rosa */
            .proj-pagination nav[role="navigation"] span[aria-current] span {
                background: #FF2D87;
                border-color: #FF2D87;
                color: #fff;
                cursor: default;
            }

            .proj-pagination nav[role="navigation"] svg {
                width: 16px;
                height: 16px;
            }
        </style>

    </div>
</section>
@endsection