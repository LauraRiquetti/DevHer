@extends('layouts.app')

@section('title', 'Novo tópico — ' . $comunidade->nome)

@section('content')

<section class="page-head">
    <div class="glow glow-1" style="top:-260px;"></div>
    <div class="wrap">
        <a href="{{ route('comunidades.show', $comunidade->slug) }}" style="color:var(--muted, #9ca3af); text-decoration:none; font-size:0.9rem;">← Voltar para {{ $comunidade->nome }}</a>
        <span class="eyebrow" style="display:block; margin-top:12px;">Novo tópico</span>
        <h1>O que você quer perguntar ou compartilhar?</h1>
    </div>
</section>

<section style="padding:48px 0 100px;">
    <div class="wrap" style="max-width:680px;">

        {{-- Mensagens de validação --}}
        @if ($errors->any())
            <div style="padding: 12px 16px; background: #f8d7da; color: #721c24; border-radius: 6px; margin-bottom: 24px;">
                <ul style="margin:0; padding-left:18px;">
                    @foreach ($errors->all() as $erro)
                        <li>{{ $erro }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('topicos.store', $comunidade->slug) }}">
            @csrf

            <label for="titulo" style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:6px;">Título</label>
            <input
                type="text"
                id="titulo"
                name="titulo"
                value="{{ old('titulo') }}"
                placeholder="Ex: Como estruturar minha primeira API em Laravel?"
                required
                style="width:100%; padding:12px 14px; border-radius:8px; border:1px solid rgba(255,45,135,0.25); background:transparent; color:inherit; margin-bottom:20px;"
            >

            <label for="mensagem" style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:6px;">Mensagem</label>
            <textarea
                id="mensagem"
                name="mensagem"
                rows="8"
                placeholder="Conte com detalhes sua dúvida ou o que você quer compartilhar com a comunidade..."
                required
                style="width:100%; padding:12px 14px; border-radius:8px; border:1px solid rgba(255,45,135,0.25); background:transparent; color:inherit; resize:vertical; margin-bottom:24px;"
            >{{ old('mensagem') }}</textarea>

            <button type="submit" class="btn btn-primary">Publicar tópico</button>
        </form>

    </div>
</section>
@endsection