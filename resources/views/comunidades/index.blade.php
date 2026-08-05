@extends('layouts.app')

@section('title', 'Comunidade')

@section('content')

<section class="page-head">
    <div class="glow glow-1" style="top:-260px;"></div>
    <div class="wrap">
        <span class="eyebrow">Comunidade</span>
        <h1>Redes e iniciativas que caminham com a gente</h1>
        <p>Entre num fórum, tire dúvidas e troque experiências com outras mulheres da tecnologia.</p>
    </div>
</section>

<section style="padding:48px 0 100px;">
    <div class="wrap">

        <div class="proj-grid" style="margin-top:8px;">
            @forelse ($comunidades as $comunidade)
                <a href="{{ route('comunidades.show', $comunidade->slug) }}" class="proj-card" style="display:block; text-decoration:none; color:inherit;">
                    <span class="categoria">{{ $comunidade->topicos_count }} {{ Str::plural('tópico', $comunidade->topicos_count) }}</span>
                    <h4>{{ $comunidade->nome }}</h4>
                    <p style="color:var(--muted, #6b7280); font-size:0.9rem; margin-top:8px; line-height:1.5;">
                        {{ $comunidade->descricao }}
                    </p>
                    <span class="btn btn-ghost btn-sm btn-block" style="margin-top:16px;">Entrar no fórum</span>
                </a>
            @empty
                <p style="color:var(--muted);">Nenhuma comunidade cadastrada ainda.</p>
            @endforelse
        </div>

    </div>
</section>
@endsection