@extends('Layouts.app')

@section('title', 'Cursos')

@section('content')

<section class="page-head">
    <div class="glow glow-1" style="top:-260px;"></div>
    <div class="wrap">
        <span class="eyebrow">Aprender</span>
        <h1>Cursos e mentorias</h1>
        <p>Conteúdos publicados pelas vendedoras da comunidade, do primeiro código à especialização.</p>
        @if (session('vendedora_id'))
            <a href="{{ route('cursos.create') }}" class="btn btn-primary btn-sm" style="margin-top:18px;">+ Publicar curso</a>
        @endif
    </div>
</section>

<section style="padding:48px 0 100px;">
    <div class="wrap">

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="proj-grid">
            @forelse ($cursos as $curso)
                <div class="proj-card">
                    @if ($curso->imagem)
                        <div class="proj-thumb" style="background-image:url('{{ $curso->imagem }}');background-size:cover;background-position:center;"></div>
                    @else
                        <div class="proj-thumb"></div>
                    @endif

                    @if ($curso->categoria)
                        <span class="categoria">{{ $curso->categoria }}</span>
                    @endif

                    <h4>{{ $curso->nome }}</h4>

                    @if ($curso->descricao)
                        <p style="font-size:12.5px;color:var(--muted);margin-top:6px;">
                            {{ Str::limit($curso->descricao, 80) }}
                        </p>
                    @endif

                    <div style="display:flex;align-items:center;justify-content:space-between;margin-top:12px;">
                        @if ((float) $curso->preco <= 0)
                            <span class="badge-free">Gratuito</span>
                        @else
                            <span class="price">R$ {{ number_format($curso->preco, 2, ',', '.') }}</span>
                        @endif
                    </div>

                    @if ((float) $curso->preco <= 0)
                        {{-- Curso gratuito: acesso direto ao material, sem passar pelo carrinho --}}
                        @if ($curso->link_material)
                            <a href="{{ $curso->link_material }}" target="_blank" rel="noopener" class="btn btn-primary btn-sm btn-block" style="margin-top:12px;">
                                Acessar material
                            </a>
                        @else
                            <span class="btn btn-ghost btn-sm btn-block" style="margin-top:12px;opacity:.6;cursor:default;">
                                Material em breve
                            </span>
                        @endif
                    @else
                        {{-- Curso pago: precisa estar logada e passa pelo carrinho --}}
                        @if (session('vendedora_id'))
                            <form method="POST" action="{{ route('carrinho.add') }}" style="margin-top:12px;">
                                @csrf
                                <input type="hidden" name="curso_id" value="{{ $curso->id }}">
                                <button type="submit" class="btn btn-ghost btn-sm btn-block">Adicionar ao carrinho</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-ghost btn-sm btn-block" style="margin-top:12px;">
                                Entrar para comprar
                            </a>
                        @endif
                    @endif
                </div>
            @empty
                <p style="color:var(--muted);">Nenhum curso publicado ainda.</p>
            @endforelse
        </div>
    </div>
</section>
@endsection