@extends('Layouts.app')

@section('title', 'Cursos — ' . ($categoria ?? ''))

@section('content')

<section class="page-head">
    <div class="wrap">
        <span class="eyebrow">Categoria</span>
        <h1>{{ $categoria }}</h1>
        <p>Cursos filtrados por esta categoria.</p>
        <a href="{{ route('cursos.index') }}" class="btn btn-ghost btn-sm" style="margin-top:14px;">← Ver todos os cursos</a>
    </div>
</section>

<section style="padding:48px 0 100px;">
    <div class="wrap">
        <div class="proj-grid">
            @forelse ($cursos as $curso)
                <div class="proj-card">
                    @if ($curso->imagem)
                        <div class="proj-thumb" style="background-image:url('{{ $curso->imagem }}');background-size:cover;background-position:center;"></div>
                    @else
                        <div class="proj-thumb"></div>
                    @endif
                    <span class="categoria">{{ $curso->categoria }}</span>
                    <h4>{{ $curso->nome }}</h4>
                    @if ((float) $curso->preco <= 0)
                        <span class="badge-free">Gratuito</span>
                    @else
                        <span class="price">R$ {{ number_format($curso->preco, 2, ',', '.') }}</span>
                    @endif
                </div>
            @empty
                <p style="color:var(--muted);">Nenhum curso encontrado nessa categoria.</p>
            @endforelse
        </div>
    </div>
</section>
@endsection