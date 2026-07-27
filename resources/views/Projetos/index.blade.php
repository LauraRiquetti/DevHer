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

        {{-- Mensagem de Sucesso --}}
        @if (session('success'))
            <div style="padding: 12px 16px; background: #d4edda; color: #155724; border-radius: 6px; margin-bottom: 24px;">
                {{ session('success') }}
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
                <a href="{{ route('projetos.create') }}" class="btn btn-primary btn-sm">+ Publicar projeto</a>
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
                        <form method="POST" action="{{ route('carrinho.add', $projeto->id) ?? '#' }}" style="margin-top:12px;">
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
        <div style="margin-top:32px;">
            {{ $projetos->links() }}
        </div>

    </div>
</section>
@endsection