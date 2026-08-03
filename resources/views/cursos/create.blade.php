@extends('Layouts.app')

@section('title', 'Publicar curso')

@section('content')

<section class="page-head">
    <div class="wrap">
        <span class="eyebrow">Nova publicação</span>
        <h1>Publicar um curso</h1>
        <p>Deixe o preço como <strong>0</strong> para publicar um curso gratuito com acesso direto ao material.</p>
    </div>
</section>

<section style="padding:48px 0 100px;">
    <div class="wrap" style="max-width:620px;">
        <div class="card">

            @if ($errors->any())
                <div class="alert alert-error">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('cursos.store') }}">
                @csrf

                <div class="field">
                    <label for="nome">Nome do curso</label>
                    <input type="text" name="nome" id="nome" placeholder="Ex: Lógica de programação do zero" value="{{ old('nome') }}" required>
                </div>

                <div class="field">
                    <label for="descricao">Descrição</label>
                    <textarea name="descricao" id="descricao" placeholder="Do que se trata o curso, pré-requisitos, carga horária...">{{ old('descricao') }}</textarea>
                </div>

                <div class="field-row">
                    <div class="field">
                        <label for="categoria">Categoria</label>
                        <select name="categoria" id="categoria">
                            <option value="">Selecione</option>
                            <option value="Front-end">Front-end</option>
                            <option value="Back-end">Back-end</option>
                            <option value="UX/UI">UX/UI</option>
                            <option value="Dados">Dados</option>
                            <option value="Segurança">Segurança</option>
                            <option value="Mobile">Mobile</option>
                            <option value="Carreira">Carreira</option>
                        </select>
                    </div>
                    <div class="field">
                        <label for="preco">Preço (R$)</label>
                        <input type="number" step="0.01" min="0" name="preco" id="preco" placeholder="0,00 = gratuito" value="{{ old('preco', 0) }}" required>
                    </div>
                </div>

                <div class="field">
                    <label for="imagem">URL da imagem de capa</label>
                    <input type="text" name="imagem" id="imagem" placeholder="https://..." value="{{ old('imagem') }}">
                </div>

                <div class="field">
                    <label for="link_material">Link do material (vídeo, PDF, playlist...)</label>
                    <input type="url" name="link_material" id="link_material" placeholder="https://..." value="{{ old('link_material') }}">
                    <small style="color:var(--muted-2);font-size:12px;display:block;margin-top:6px;">
                        Em cursos gratuitos, esse link fica disponível direto na listagem.
                    </small>
                </div>

                <div style="display:flex;gap:12px;margin-top:8px;">
                    <button type="submit" class="btn btn-primary">Publicar curso</button>
                    <a href="{{ route('cursos.index') }}" class="btn btn-ghost">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection