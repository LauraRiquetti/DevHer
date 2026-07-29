@extends('layouts.app')

@section('title', 'Perfil de ' . ($vendedora->nome ?? $vendedora->user->name))

@section('content')
<section class="page-head">
    <div class="wrap">
        <div class="profile-head reveal in" style="display: flex; align-items: center; gap: 16px;">
            <div class="avatar" style="width: 64px; height: 64px; background-color: var(--pink-light, #e83e8c); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 24px;">
                {{ strtoupper(substr($vendedora->nome ?? $vendedora->user->name, 0, 1)) }}
            </div>
            <div>
                <h4 style="font-size:22px; margin:0;">{{ $vendedora->nome ?? $vendedora->user->name }}</h4>
                <span style="color:var(--muted); font-size:14px;">
                    {{ $vendedora->area ?? 'Criadora & Desenvolvedora' }} · {{ $vendedora->projetos->count() }} projetos publicados
                </span>
            </div>
        </div>
        <div class="stars" style="margin-top: 12px;">
            ★★★★★ 
            <span style="color:var(--muted); font-family:var(--mono); font-size:12px;">
                {{ number_format($vendedora->avaliacoes->avg('nota') ?? 5.0, 1) }} 
                ({{ $vendedora->avaliacoes->count() }} avaliações)
            </span>
        </div>
    </div>
</section>

<section style="padding:48px 0 100px;">
    <div class="wrap" style="display:grid; grid-template-columns:1.4fr 1fr; gap:40px;">

        <!-- Coluna de Projetos -->
        <div>
            <div class="panel-title"><h3>Projetos publicados</h3></div>
            <div class="proj-grid">
                @forelse ($vendedora->projetos as $projeto)
                    <div class="proj-card">
                        <div class="proj-thumb"></div>
                        <h4>{{ $projeto->titulo }}</h4>
                        <span class="price">R$ {{ number_format($projeto->preco, 2, ',', '.') }}</span>
                    </div>
                @empty
                    <p style="color:var(--muted); font-size:14px;">Esta criadora ainda não publicou projetos.</p>
                @endforelse
            </div>
        </div>

        <!-- Coluna de Avaliações -->
        <div>
            <div class="panel-title"><h3>Avaliações e comentários</h3></div>
            <div class="card">
                @forelse ($vendedora->avaliacoes as $avaliacao)
                    <div class="review" style="margin-bottom: 12px; padding-bottom: 8px; border-bottom: 1px solid #eee;">
                        <b>{{ $avaliacao->user->name ?? $avaliacao->autora ?? 'Usuária' }}:</b> "{{ $avaliacao->comentario ?? $avaliacao->texto }}"
                    </div>
                @empty
                    <p style="color:var(--muted); font-size:13px;">Nenhuma avaliação ainda. Seja a primeira a avaliar!</p>
                @endforelse

                @auth
                    @if(session('success'))
                        <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin-top: 15px; font-size: 13px;">
                            {{ session('success') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('avaliacoes.store') }}" style="margin-top:20px;">
                        @csrf
                        <input type="hidden" name="vendedora_id" value="{{ $vendedora->id }}">
                        <div class="field">
                            <label for="comentario">Deixe sua avaliação</label>
                            <textarea name="comentario" id="comentario" required placeholder="Conte como foi sua experiência..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm" style="margin-top: 10px;">Enviar avaliação</button>
                    </form>
                @else
                    <p style="font-size:13px; color:var(--muted-2); margin-top:16px;">
                        <a href="{{ route('login') }}" style="color:var(--pink-light);">Entre</a> para avaliar esta criadora.
                    </p>
                @endauth
            </div>
        </div>

    </div>
</section>
@endsection