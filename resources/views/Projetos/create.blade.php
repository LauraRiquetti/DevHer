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
                <div class="alert alert-error">{{ $errors->first() }}</div>
            @endif

            {{-- RF02: título, descrição, categoria, preço e arquivos --}}
            <form method="POST" action="{{ route('projetos.store') ?? '#' }}" enctype="multipart/form-data">
                @csrf

                <div class="field">
                    <label for="titulo">Título do projeto</label>
                    <input type="text" name="titulo" id="titulo" placeholder="Ex: Dashboard financeiro em React" value="{{ old('titulo') }}" required>
                </div>

                <div class="field">
                    <label for="descricao">Descrição</label>
                    <textarea name="descricao" id="descricao" placeholder="Conte do que se trata o projeto, tecnologias usadas e o que está incluso.">{{ old('descricao') }}</textarea>
                </div>

                <div class="field-row">
                    <div class="field">
                        <label for="categoria">Categoria</label>
                        <select name="categoria" id="categoria" required>
                            <option value="">Selecione</option>
                            <option value="Front-end">Front-end</option>
                            <option value="Back-end">Back-end</option>
                            <option value="UX/UI">UX/UI</option>
                            <option value="Dados">Dados</option>
                            <option value="Segurança">Segurança</option>
                            <option value="Mobile">Mobile</option>
                        </select>
                    </div>
                    <div class="field">
                        <label for="preco">Preço (R$)</label>
                        <input type="number" step="0.01" min="0" name="preco" id="preco" placeholder="0,00" value="{{ old('preco') }}" required>
                    </div>
                </div>

                <div class="field">
                    <label for="arquivos">Arquivos do projeto</label>
                    <input type="file" name="arquivos[]" id="arquivos" multiple>
                    <small style="color:var(--muted-2);font-size:12px;display:block;margin-top:6px;">
                        Aceita .zip, .rar, imagens ou PDFs de documentação.
                    </small>
                </div>

                <div style="display:flex;gap:12px;margin-top:8px;">
                    <button type="submit" class="btn btn-primary">Publicar projeto</button>
                    <a href="{{ route('projetos.index') ?? '#' }}" class="btn btn-ghost">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection