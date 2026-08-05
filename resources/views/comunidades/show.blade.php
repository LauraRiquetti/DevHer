@extends('layouts.app')

@section('title', $comunidade->nome)

@section('content')

<section class="page-head">
    <div class="glow glow-1" style="top:-260px;"></div>
    <div class="wrap">
        <a href="{{ route('comunidades.index') }}" style="color:var(--muted, #9ca3af); text-decoration:none; font-size:0.9rem;">← Todas as comunidades</a>
        <span class="eyebrow" style="display:block; margin-top:12px;">Fórum</span>
        <h1>{{ $comunidade->nome }}</h1>
        <p>{{ $comunidade->descricao }}</p>
    </div>
</section>

<section style="padding:48px 0 100px;">
    <div class="wrap">

        {{-- Mensagem de sucesso (ex: tópico criado) --}}
        @if (session('sucesso'))
            <div style="padding: 12px 16px; background: #d4edda; color: #155724; border-radius: 6px; margin-bottom: 24px;">
                {{ session('sucesso') }}
            </div>
        @endif

        <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:24px;">
            <h3 style="margin:0;">Tópicos</h3>
            @auth
                <a href="{{ route('topicos.create', $comunidade->slug) }}" class="btn btn-primary btn-sm">+ Novo tópico</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-ghost btn-sm">Entrar para participar</a>
            @endauth
        </div>

        <div style="display:flex; flex-direction:column; gap:12px;">
            @forelse ($topicos as $topico)
                <a href="{{ route('topicos.show', $topico->id) }}" class="course-row" style="text-decoration:none; color:inherit;">
                    <div class="course-thumb">
                        {{ Str::upper(Str::substr($topico->user->name ?? '?', 0, 2)) }}
                    </div>
                    <div>
                        <h4>{{ $topico->titulo }}</h4>
                        <span>
                            por {{ $topico->user->name ?? 'Usuária' }} · {{ $topico->created_at->diffForHumans() }}
                        </span>
                    </div>
                    <span class="badge-free">{{ $topico->respostas_count }} {{ Str::plural('resposta', $topico->respostas_count) }}</span>
                </a>
            @empty
                <p style="color:var(--muted); text-align:center; padding: 32px 0;">
                    Ainda não tem nenhum tópico aqui. Que tal começar a conversa?
                </p>
            @endforelse
        </div>

        <div style="margin-top:32px;">
            {{ $topicos->links() }}
        </div>

        <style>
            /* Mesmo ajuste de paginação sem Tailwind usado nas outras listagens do site */
            nav[role="navigation"] > div[class*="sm:hidden"] { display: none !important; }
            nav[role="navigation"] > div.hidden {
                display: flex !important;
                align-items: center;
                justify-content: space-between;
                flex-wrap: wrap;
                gap: 16px;
            }
            nav[role="navigation"] span.relative { display: inline-flex; align-items: center; gap: 4px; flex-wrap: wrap; }
            nav[role="navigation"] p { margin: 0; font-size: 0.85rem; color: var(--muted, #6b7280); }
            nav[role="navigation"] a,
            nav[role="navigation"] span[aria-current] span {
                display: inline-flex; align-items: center; justify-content: center;
                min-width: 38px; height: 38px; padding: 0 10px; border-radius: 8px;
                border: 1px solid rgba(255, 45, 135, 0.25); background: #fff; color: #1c1c1c;
                font-size: 0.85rem; font-weight: 600; text-decoration: none; transition: all .2s ease;
            }
            nav[role="navigation"] a:hover { border-color: #FF2D87; color: #FF2D87; background: rgba(255, 45, 135, 0.06); }
            nav[role="navigation"] span[aria-current] span { background: #FF2D87; border-color: #FF2D87; color: #fff; cursor: default; }
            nav[role="navigation"] svg { width: 16px; height: 16px; }
        </style>

    </div>
</section>
@endsection