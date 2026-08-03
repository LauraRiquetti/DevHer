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
    <div class="wrap">

        {{-- Mensagem de Sucesso --}}
        @if (session('sucesso'))
            <div style="padding: 12px 16px; background: #d4edda; color: #155724; border-radius: 6px; margin-bottom: 24px;">
                {{ session('sucesso') }}
            </div>
        @endif

        {{-- Toolbar de Filtro e Busca --}}
        <form method="GET" action="{{ route('cursos.index') }}" class="table-toolbar">
            <input type="text" name="busca" placeholder="Buscar curso..." value="{{ request('busca') }}">
            
            <div style="display:flex; gap:10px; flex-wrap:wrap;">
                <label class="chip" style="cursor:pointer;">
                    <input type="radio" name="filtro" value="" style="display:none;"
                           {{ !request('filtro') ? 'checked' : '' }} onchange="this.form.submit()">
                    Todos
                </label>
                <label class="chip" style="cursor:pointer;">
                    <input type="radio" name="filtro" value="gratuito" style="display:none;"
                           {{ request('filtro') === 'gratuito' ? 'checked' : '' }} onchange="this.form.submit()">
                    Gratuitos
                </label>
                <label class="chip" style="cursor:pointer;">
                    <input type="radio" name="filtro" value="pago" style="display:none;"
                           {{ request('filtro') === 'pago' ? 'checked' : '' }} onchange="this.form.submit()">
                    Pagos
                </label>
            </div>

            @auth
                <a href="{{ route('cursos.create') }}" class="btn btn-primary btn-sm">+ Publicar curso</a>
            @endauth
        </form>

        {{-- Lista de Cursos --}}
        <div style="max-width:760px; margin: 32px auto 0 auto;">
            @forelse ($cursos as $curso)
                @php 
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
                    Nenhum curso encontrado para este filtro.
                </p>
            @endforelse
        </div>

        {{-- Paginação --}}
        @if (method_exists($cursos, 'links'))
            <div style="margin-top:32px; text-align:center;">
                {{ $cursos->links() }}
            </div>
        @endif

    </div>
</section>
@endsection