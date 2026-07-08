@extends('Layouts.app')

@section('title', $criadora['nome'] ?? 'Perfil da criadora')

@section('content')

@php
    $criadora = $criadora ?? ['nome' => 'Carolina Reis', 'area' => 'Segurança da informação', 'nota' => 4.9, 'total_avaliacoes' => 38];
    $projetos = $projetos ?? [
        ['titulo' => 'Scanner de vulnerabilidades', 'preco' => '150,00'],
        ['titulo' => 'Checklist de segurança para APIs', 'preco' => '45,00'],
    ];
    $avaliacoes = $avaliacoes ?? [
        ['autora' => 'Fernanda', 'texto' => 'Curso direto ao ponto, mentoria excelente para quem está migrando de área.'],
        ['autora' => 'Juliana', 'texto' => 'Material muito bem organizado, recomendo para iniciantes em segurança.'],
    ];
@endphp

<section class="page-head">
    <div class="wrap">
        <div class="profile-head reveal in">
            <div class="avatar"></div>
            <div>
                <h4 style="font-size:22px;">{{ $criadora['nome'] }}</h4>
                <span>{{ $criadora['area'] }} · {{ count($projetos) }} projetos publicados</span>
            </div>
        </div>
        <div class="stars">
            ★★★★★ <span style="color:var(--muted);font-family:var(--mono);font-size:12px;">
                {{ $criadora['nota'] }} ({{ $criadora['total_avaliacoes'] }} avaliações)
            </span>
        </div>
    </div>
</section>

<section style="padding:48px 0 100px;">
    <div class="wrap" style="display:grid;grid-template-columns:1.4fr 1fr;gap:40px;">

        <div>
            <div class="panel-title"><h3>Projetos publicados</h3></div>
            <div class="proj-grid">
                @foreach ($projetos as $projeto)
                    <div class="proj-card">
                        <div class="proj-thumb"></div>
                        <h4>{{ $projeto['titulo'] }}</h4>
                        <span class="price">R$ {{ $projeto['preco'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div>
            <div class="panel-title"><h3>Avaliações e comentários</h3></div>
            <div class="card">
                @foreach ($avaliacoes as $avaliacao)
                    <div class="review">
                        <b>{{ $avaliacao['autora'] }}:</b> "{{ $avaliacao['texto'] }}"
                    </div>
                @endforeach

                {{-- RF08: usuárias autenticadas podem avaliar e comentar --}}
                @auth
                    <form method="POST" action="{{ route('avaliacoes.store') ?? '#' }}" style="margin-top:20px;">
                        @csrf
                        <input type="hidden" name="criadora_id" value="{{ $criadora['id'] ?? '' }}">
                        <div class="field">
                            <label for="comentario">Deixe sua avaliação</label>
                            <textarea name="comentario" id="comentario" placeholder="Conte como foi sua experiência..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">Enviar avaliação</button>
                    </form>
                @else
                    <p style="font-size:13px;color:var(--muted-2);margin-top:16px;">
                        <a href="{{ route('login') ?? '#' }}" style="color:var(--pink-light);">Entre</a> para avaliar esta criadora.
                    </p>
                @endauth
            </div>
        </div>
    </div>
</section>
@endsection