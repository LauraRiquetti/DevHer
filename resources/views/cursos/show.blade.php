@extends('layouts.app')

@section('title', $curso->nome)

@section('content')

<section class="page-head">
    <div class="glow glow-1" style="top:-260px;"></div>
    <div class="wrap">
        <span class="eyebrow">Cursos</span>
        <h1>{{ $curso->nome }}</h1>
        @if($curso->categoria)
            <p>Categoria: {{ $curso->categoria }}</p>
        @endif
    </div>
</section>

<section style="padding:48px 0 100px;">
    <div class="wrap">

        @php
            // Mesma lógica de restrição de idade usada na listagem de cursos
            $isRestrito = isset($curso->is_18plus) ? $curso->is_18plus : ($curso->categoria === '18+');
            $bloqueado = $isRestrito && ($idadeUsuaria === null || $idadeUsuaria < 18);
        @endphp

        <a href="{{ route('cursos.index') }}" class="btn btn-ghost btn-sm" style="margin-bottom:24px; display:inline-block;">
            ← Voltar para cursos
        </a>

        <div style="display:flex; gap:40px; flex-wrap:wrap; align-items:flex-start;">

            {{-- Imagem do curso --}}
            <div class="proj-thumb" style="flex:1 1 320px; max-width:420px; aspect-ratio:4/3; border-radius:12px; overflow:hidden;">
                @if($curso->imagem)
                    <img src="{{ $curso->imagem }}" alt="{{ $curso->nome }}" style="width:100%; height:100%; object-fit:cover;">
                @endif
            </div>

            {{-- Informações do curso --}}
            <div style="flex:2 1 380px;">
                @if($curso->categoria)
                    <span class="categoria" style="text-transform: capitalize;">{{ $curso->categoria }}</span>
                @endif

                <h2 style="margin-top:12px;">{{ $curso->nome }}</h2>
                <span class="autora">por {{ $curso->user->name ?? 'Autora desconhecida' }}</span>

                {{-- Descrição do curso --}}
                <p style="margin-top:20px; line-height:1.7; color:var(--muted, #6b7280);">
                    {{ $curso->descricao ?? 'Sem descrição disponível para este curso.' }}
                </p>

                <div style="margin-top:20px; display:flex; align-items:center; gap:16px; flex-wrap:wrap;">
                    <span class="price" style="font-size:1.4rem;">
                        @if(($curso->preco ?? 0) == 0)
                            Gratuito
                        @else
                            R$ {{ number_format($curso->preco, 2, ',', '.') }}
                        @endif
                    </span>

                    @if ($isRestrito)
                        <span class="badge-18">18+</span>
                    @else
                        <span class="badge-free">Livre</span>
                    @endif
                </div>

                @if ($bloqueado)
                    <p style="font-size:13px;color:var(--muted-2);margin-top:16px;">
                        Este curso é liberado apenas para usuárias com 18 anos ou mais.
                    </p>
                    <button class="btn btn-ghost btn-sm" disabled style="opacity:0.6; cursor:not-allowed; margin-top:16px;">
                        Indisponível
                    </button>
                @else
                    {{-- Mesmo padrão de rota usado no marketplace e na listagem de cursos --}}
                    <form method="POST" action="{{ route('carrinho.add', ['tipo' => 'curso', 'id' => $curso->id]) }}" style="margin-top:24px;">
                        @csrf
                        <button type="submit" class="btn btn-primary">Adicionar ao carrinho</button>
                    </form>
                @endif
            </div>
        </div>

    </div>
</section>
@endsection