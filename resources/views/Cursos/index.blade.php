@extends('layouts.app')

@section('title', 'Cursos')

@section('content')

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
        @forelse ($cursos as $curso)
            @php 
                // Verifica se o curso tem a flag/propriedade de restrição (ex: via categoria ou atributo is_18plus)
                $isRestrito = isset($curso->is_18plus) ? $curso->is_18plus : ($curso->categoria === '18+');
                $bloqueado = $isRestrito && ($idadeUsuaria === null || $idadeUsuaria < 18); 
            @endphp

            <div class="course-row" style="{{ $bloqueado ? 'opacity:.55;' : '' }}">
                <div class="course-thumb">
                    {{ Str::upper(Str::substr($curso->nome, 0, 2)) }}
                </div>
                <div>
                    <h4>{{ $curso->nome }}</h4>
                    <span>
                        @if(($curso->preco ?? 0) == 0)
                            Gratuito
                        @else
                            R$ {{ number_format($curso->preco, 2, ',', '.') }}
                        @endif
                        @if($curso->duracao)
                            · {{ $curso->duracao }}
                        @endif
                    </span>
                </div>

                @if ($isRestrito)
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
        @empty
            <p style="color:var(--muted); text-align:center; padding: 32px 0;">
                Nenhum curso cadastrado no momento.
            </p>
        @endforelse
    </div>
</section>
@auth
    @if(auth()->user()->tipo === 'vendedora')
        <div style="margin-bottom: 24px; text-align: right;">
            <a href="{{ route('cursos.create') }}" class="btn btn-primary">+ Novo Curso</a>
        </div>
    @endif
@endauth
@endsection