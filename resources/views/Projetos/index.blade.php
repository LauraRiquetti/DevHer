@extends('layouts.app')

@section('title', 'Marketplace de Projetos')

@section('content')

{{--
    Espera-se que o controller envie a variável $projetos (paginada) e $categorias.
    Abaixo, um fallback de exemplo para a tela já nascer funcional na tela.
--}}
@php
    $projetos = $projetos ?? [
        ['titulo' => 'Dashboard financeiro em React', 'categoria' => 'Front-end', 'preco' => '89,00', 'autora' => 'Mariana Costa'],
        ['titulo' => 'API de agendamento em Node.js', 'categoria' => 'Back-end', 'preco' => '120,00', 'autora' => 'Ana Beatriz'],
        ['titulo' => 'UI Kit — Design System Rosa', 'categoria' => 'UX/UI', 'preco' => '65,00', 'autora' => 'Luiza Prado'],
        ['titulo' => 'Bot de análise de dados com Python', 'categoria' => 'Dados', 'preco' => '99,00', 'autora' => 'Bianca Silva'],
        ['titulo' => 'Scanner de vulnerabilidades', 'categoria' => 'Segurança', 'preco' => '150,00', 'autora' => 'Carolina Reis'],
        ['titulo' => 'App de organização de estudos', 'categoria' => 'Mobile', 'preco' => '75,00', 'autora' => 'Fernanda Alves'],
    ];
    $categorias = $categorias ?? ['Todas', 'Front-end', 'Back-end', 'UX/UI', 'Dados', 'Segurança', 'Mobile'];
@endphp

<section class="page-head">
    <div class="glow glow-1" style="top:-260px;"></div>
    <div class="wrap">
        <span class="eyebrow">Marketplace</span>
        <h1>Projetos publicados pela comunidade</h1>
        <p>Filtre por categoria, veja quem criou e adicione ao carrinho.</p>
    </div>
</section>

<section style="padding:48px 0 100px;">
    <div class="wrap">

        {{-- RF03: busca e filtro por categoria --}}
        <form method="GET" action="{{ route('projetos.index') ?? '#' }}" class="table-toolbar">
            <input type="text" name="busca" placeholder="Buscar projeto..." value="{{ request('busca') }}">
            <div style="display:flex;gap:10px;flex-wrap:wrap;">
                @foreach ($categorias as $categoria)
                    <label class="chip" style="cursor:pointer;">
                        <input type="radio" name="categoria" value="{{ $categoria }}" style="display:none;"
                               {{ request('categoria', 'Todas') === $categoria ? 'checked' : '' }}
                               onchange="this.form.submit()">
                        {{ $categoria }}
                    </label>
                @endforeach
            </div>
            @if (auth()->check() ?? false)
                <a href="{{ route('projetos.create') ?? '#' }}" class="btn btn-primary btn-sm">+ Publicar projeto</a>
            @endif
        </form>

        <div class="proj-grid" style="margin-top:32px;">
            @forelse ($projetos as $projeto)
                <div class="proj-card">
                    <div class="proj-thumb"></div>
                    <span class="categoria">{{ $projeto['categoria'] }}</span>
                    <h4>{{ $projeto['titulo'] }}</h4>
                    <span class="autora">por {{ $projeto['autora'] }}</span>
                    <span class="price">R$ {{ $projeto['preco'] }}</span>
                    <form method="POST" action="{{ route('carrinho.add') ?? '#' }}" style="margin-top:12px;">
                        @csrf
                        <button type="submit" class="btn btn-ghost btn-sm btn-block">Adicionar ao carrinho</button>
                    </form>
                </div>
            @empty
                <p style="color:var(--muted);">Nenhum projeto encontrado para esse filtro.</p>
            @endforelse
        </div>

        {{-- Laravel: {{ $projetos->links() }} caso esteja usando paginate() --}}
    </div>
</section>
@endsection