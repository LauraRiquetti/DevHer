@extends('layouts.app')

@section('title', $projeto->nome)

@section('content')

<section class="page-head">
    <div class="glow glow-1" style="top:-260px;"></div>
    <div class="wrap">
        <span class="eyebrow">Marketplace</span>
        <h1>{{ $projeto->nome }}</h1>
        <p>Publicado por {{ $projeto->user->name ?? 'Autor Desconhecido' }}</p>
    </div>
</section>

<section style="padding:48px 0 100px;">
    <div class="wrap">

        <a href="{{ route('projetos.index') }}" class="btn btn-ghost btn-sm" style="margin-bottom:24px; display:inline-block;">
            ← Voltar para o marketplace
        </a>

        <div style="display:flex; gap:40px; flex-wrap:wrap; align-items:flex-start;">

            {{-- Nome do projeto centralizado no lugar da imagem --}}
            <div class="proj-thumb proj-thumb-nome" style="flex:1 1 320px; max-width:420px; aspect-ratio:4/3; border-radius:12px; overflow:hidden; display:flex; align-items:center; justify-content:center; text-align:center; padding:24px;">
                <span style="color:#fff; font-weight:700; font-size:1.4rem; line-height:1.35; text-shadow:0 1px 3px rgba(0,0,0,0.25);">{{ $projeto->nome }}</span>
            </div>

            {{-- Informações do projeto --}}
            <div style="flex:2 1 380px;">
                <span class="categoria" style="text-transform: capitalize;">{{ $projeto->status }}</span>

                <h2 style="margin-top:12px;">{{ $projeto->nome }}</h2>
                <span class="autora">por {{ $projeto->user->name ?? 'Autor Desconhecido' }}</span>

                {{-- Descrição do projeto --}}
                <p style="margin-top:20px; line-height:1.7; color:var(--muted, #6b7280);">
                    {{ $projeto->descricao ?? 'Sem descrição disponível para este projeto.' }}
                </p>

                <div style="margin-top:20px;">
                    <span class="price" style="font-size:1.4rem;">
                        R$ {{ number_format($projeto->preco, 2, ',', '.') }}
                    </span>
                </div>

                @if($projeto->status === 'disponivel')
                    {{-- Mesmo padrão de rota usado na listagem do marketplace --}}
                    <form method="POST" action="{{ route('carrinho.add', ['tipo' => 'projeto', 'id' => $projeto->id]) }}" style="margin-top:24px;">
                        @csrf
                        <button type="submit" class="btn btn-primary">Adicionar ao carrinho</button>
                    </form>
                @else
                    <button class="btn btn-ghost btn-sm" disabled style="opacity:0.6; cursor:not-allowed; margin-top:24px;">
                        Indisponível
                    </button>
                @endif
            </div>
        </div>

    </div>
</section>
@endsection