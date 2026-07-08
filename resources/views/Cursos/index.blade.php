@extends('Layouts.app')

@section('title', 'Cursos')

@section('content')

@php
    $cursos = $cursos ?? [
        ['titulo' => 'Lógica de programação do zero', 'carga' => '4h', 'preco' => null, 'restrito' => false],
        ['titulo' => 'Segurança ofensiva na prática', 'carga' => '8h', 'preco' => '149,00', 'restrito' => true],
        ['titulo' => 'Design de produto para devs', 'carga' => '5h', 'preco' => '79,00', 'restrito' => false],
        ['titulo' => 'Introdução a bancos de dados', 'carga' => '6h', 'preco' => null, 'restrito' => false],
    ];
    // RF06: idade mínima calculada a partir da data de nascimento do usuário autenticado
    $idadeUsuaria = $idadeUsuaria ?? null;
@endphp

<section class="page-head">
    <div class="glow glow-1" style="top:-260px;"></div>
    <div class="wrap">
        <span class="eyebrow">Aprender</span>
        <h1>Cursos e mentorias</h1>
        <p>Conteúdos publicados por criadoras da comunidade, do primeiro código à especialização.</p>
    </div>
</section>

<section style="padding:48px 0 100px;">
    <div class="wrap" style="max-width:760px;">
        @foreach ($cursos as $curso)
            @php $bloqueado = $curso['restrito'] && ($idadeUsuaria === null || $idadeUsuaria < 18); @endphp
            <div class="course-row" style="{{ $bloqueado ? 'opacity:.55;' : '' }}">
                <div class="course-thumb">{{ Str::upper(Str::substr($curso['titulo'], 0, 2)) }}</div>
                <div>
                    <h4>{{ $curso['titulo'] }}</h4>
                    <span>{{ $curso['preco'] ? 'R$ '.$curso['preco'] : 'Gratuito' }} · {{ $curso['carga'] }}</span>
                </div>

                @if ($curso['restrito'])
                    <span class="badge-18">18+</span>
                @else
                    <span class="badge-free">Livre</span>
                @endif
            </div>

            @if ($bloqueado)
                <p style="font-size:12px;color:var(--muted-2);margin:-6px 0 16px 66px;">
                    Este curso é liberado apenas para usuárias com 18 anos ou mais.
                </p>
            @endif
        @endforeach
    </div>
</section>
@endsection