@extends('layouts.app')

@section('title', $topico->titulo)

@section('content')

<section class="page-head">
    <div class="glow glow-1" style="top:-260px;"></div>
    <div class="wrap">
        <a href="{{ route('comunidades.show', $topico->comunidade->slug) }}" style="color:var(--muted, #9ca3af); text-decoration:none; font-size:0.9rem;">
            ← Voltar para {{ $topico->comunidade->nome }}
        </a>
        <span class="eyebrow" style="display:block; margin-top:12px;">Tópico</span>
        <h1>{{ $topico->titulo }}</h1>
    </div>
</section>

<section style="padding:48px 0 100px;">
    <div class="wrap" style="max-width:760px;">

        {{-- Mensagem de sucesso (ex: resposta enviada) --}}
        @if (session('sucesso'))
            <div style="padding: 12px 16px; background: #d4edda; color: #155724; border-radius: 6px; margin-bottom: 24px;">
                {{ session('sucesso') }}
            </div>
        @endif

        {{-- Mensagem original que abriu o tópico --}}
        <div style="border:1px solid rgba(255,45,135,0.2); border-radius:12px; padding:20px; margin-bottom:24px;">
            <div style="display:flex; align-items:center; gap:10px; margin-bottom:12px;">
                <div class="course-thumb" style="margin:0;">
                    {{ Str::upper(Str::substr($topico->user->name ?? '?', 0, 2)) }}
                </div>
                <div>
                    <strong>{{ $topico->user->name ?? 'Usuária' }}</strong>
                    <div style="font-size:0.8rem; color:var(--muted, #9ca3af);">{{ $topico->created_at->diffForHumans() }}</div>
                </div>
            </div>
            <p style="margin:0; line-height:1.7; white-space:pre-line;">{{ $topico->mensagem }}</p>
        </div>

        {{-- Respostas (o bate-papo) --}}
        <h3 style="margin-bottom:16px;">
            {{ $topico->respostas->count() }} {{ Str::plural('resposta', $topico->respostas->count()) }}
        </h3>

        <div style="display:flex; flex-direction:column; gap:16px; margin-bottom:32px;">
            @forelse ($topico->respostas as $resposta)
                <div style="border-left:3px solid rgba(255,45,135,0.35); padding:4px 0 4px 16px;">
                    <div style="display:flex; align-items:center; gap:8px; margin-bottom:6px;">
                        <strong style="font-size:0.9rem;">{{ $resposta->user->name ?? 'Usuária' }}</strong>
                        <span style="font-size:0.8rem; color:var(--muted, #9ca3af);">{{ $resposta->created_at->diffForHumans() }}</span>
                    </div>
                    <p style="margin:0; line-height:1.6; white-space:pre-line;">{{ $resposta->mensagem }}</p>
                </div>
            @empty
                <p style="color:var(--muted);">Ainda não tem resposta. Seja a primeira a comentar!</p>
            @endforelse
        </div>

        {{-- Formulário de resposta --}}
        @auth
            <form method="POST" action="{{ route('respostas.store', $topico->id) }}">
                @csrf
                <label for="mensagem" style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:6px;">Sua resposta</label>
                <textarea
                    id="mensagem"
                    name="mensagem"
                    rows="4"
                    placeholder="Compartilhe sua experiência ou ajude com essa dúvida..."
                    required
                    style="width:100%; padding:12px 14px; border-radius:8px; border:1px solid rgba(255,45,135,0.25); background:transparent; color:inherit; resize:vertical; margin-bottom:16px;"
                ></textarea>
                <button type="submit" class="btn btn-primary">Responder</button>
            </form>
        @else
            <div style="text-align:center; padding:24px; border:1px dashed rgba(255,45,135,0.3); border-radius:12px;">
                <p style="margin:0 0 12px;">Entre na sua conta para participar dessa conversa.</p>
                <a href="{{ route('login') }}" class="btn btn-primary btn-sm">Entrar</a>
            </div>
        @endauth

    </div>
</section>
@endsection