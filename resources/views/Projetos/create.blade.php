@extends('layouts.app')

@section('title', 'Publicar projeto')

@section('content')

<section class="page-head">
    <div class="wrap">
        <span class="eyebrow">Nova publicação</span>
        <h1>Publicar um projeto</h1>
        <p>Preencha os dados abaixo para colocar seu projeto à venda no marketplace.</p>
    </div>
</section>

<section style="padding:48px 0 100px;">
    <div class="wrap" style="max-width:620px;">
        <div class="card">

            @if ($errors->any())
                <div class="alert alert-error" style="color: #721c24; background-color: #f8d7da; padding: 12px; border-radius: 6px; margin-bottom: 20px;">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('projetos.store') }}" enctype="multipart/form-data">
                @csrf

                {{-- Definindo o status inicial como 'disponivel' por padrão --}}
                <input type="hidden" name="status" value="disponivel">

                <div class="field">
                    <label for="nome">Título do projeto</label>
                    {{-- Alterado name="titulo" para name="nome" --}}
                    <input type="text" name="nome" id="nome" placeholder="Ex: Dashboard financeiro em React" value="{{ old('nome') }}" required>
                </div>

                <div class="field">
                    <label for="descricao">Descrição</label>
                    <textarea name="descricao" id="descricao" placeholder="Conte do que se trata o projeto, tecnologias usadas e o que está incluso.">{{ old('descricao') }}</textarea>
                </div>

                <div class="field-row" style="display: flex; gap: 16px;">
                    <div class="field" style="flex: 1;">
                        <label for="preco">Preço (R$)</label>
                        <input type="number" step="0.01" min="0" name="preco" id="preco" placeholder="0,00" value="{{ old('preco') }}" required>
                    </div>
                </div>

                <div class="field" style="margin-top: 16px;">
                    <label for="imagem_file">Imagem de capa do projeto</label>
                    {{-- Ajustado para enviar arquivo de Imagem individual --}}
                    <input type="file" name="imagem_file" id="imagem_file" accept="image/*">
                    <small style="color:var(--muted-2);font-size:12px;display:block;margin-top:6px;">
                        Envie uma captura de tela ou capa representativa (.jpg, .png, .webp).
                    </small>
                </div>

                <div style="display:flex;gap:12px;margin-top:24px;">
                    <button type="submit" class="btn btn-primary">Publicar projeto</button>
                    <a href="{{ route('projetos.index') }}" class="btn btn-ghost">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection