@extends('layouts.app')

@section('title', 'Cadastrar Novo Curso')

@section('content')

<section class="page-head">
    <div class="glow glow-1" style="top:-260px;"></div>
    <div class="wrap">
        <span class="eyebrow">Criadora</span>
        <h1>Publicar novo curso</h1>
        <p>Compartilhe seu conhecimento com a comunidade e ofereça videoaulas ou mentorias.</p>
    </div>
</section>

<section style="padding: 48px 0 100px;">
    <div class="wrap" style="max-width: 680px;">

        {{-- Exibição de erros de validação --}}
        @if ($errors->any())
            <div style="background: rgba(255, 45, 135, 0.1); border: 1px solid var(--accent, #FF2D87); border-radius: 8px; padding: 16px; margin-bottom: 24px;">
                <strong style="color: #FF2D87; display: block; margin-bottom: 8px;">Por favor, corrija os erros abaixo:</strong>
                <ul style="margin: 0; padding-left: 20px; color: var(--text, #fff); font-size: 0.9rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('cursos.store') }}" method="POST" style="background: var(--surface, rgba(255,255,255,0.03)); border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 32px;">
            @csrf

            {{-- Usuário responsável (oculto pegando a usuária autenticada ou selecionável) --}}
            @auth
                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
            @else
                <div style="margin-bottom: 20px;">
                    <label for="user_id" style="display: block; font-weight: 600; margin-bottom: 8px;">Criadora/Responsável *</label>
                    <select name="user_id" id="user_id" required style="width: 100%; padding: 12px; background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.15); border-radius: 6px; color: #fff;">
                        <option value="">Selecione o perfil criador</option>
                        @foreach (\App\Models\User::all() as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                </div>
            @endauth

            {{-- Nome do Curso --}}
            <div style="margin-bottom: 20px;">
                <label for="nome" style="display: block; font-weight: 600; margin-bottom: 8px;">Título/Nome do Curso *</label>
                <input type="text" name="nome" id="nome" value="{{ old('nome') }}" required placeholder="Ex: Lógica de Programação com Python" style="width: 100%; padding: 12px; background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.15); border-radius: 6px; color: #fff;">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px;">
                {{-- Preço --}}
                <div>
                    <label for="preco" style="display: block; font-weight: 600; margin-bottom: 8px;">Preço (R$) *</label>
                    <input type="number" step="0.01" min="0" name="preco" id="preco" value="{{ old('preco', '0.00') }}" required placeholder="0.00 para gratuito" style="width: 100%; padding: 12px; background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.15); border-radius: 6px; color: #fff;">
                    <small style="color: var(--muted, #888); font-size: 0.8rem; display: block; margin-top: 4px;">Informe 0 para curso gratuito</small>
                </div>

                {{-- Categoria --}}
                <div>
                    <label for="categoria" style="display: block; font-weight: 600; margin-bottom: 8px;">Categoria</label>
                    <select name="categoria" id="categoria" style="width: 100%; padding: 12px; background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.15); border-radius: 6px; color: #fff;">
                        <option value="">Selecione uma categoria</option>
                        <option value="Programação" {{ old('categoria') == 'Programação' ? 'selected' : '' }}>Programação</option>
                        <option value="Segurança" {{ old('categoria') == 'Segurança' ? 'selected' : '' }}>Segurança / Hacking</option>
                        <option value="Design" {{ old('categoria') == 'Design' ? 'selected' : '' }}>Design / UX</option>
                        <option value="Carreira" {{ old('categoria') == 'Carreira' ? 'selected' : '' }}>Carreira & Mentoria</option>
                        <option value="18+" {{ old('categoria') == '18+' ? 'selected' : '' }}>Conteúdo 18+</option>
                    </select>
                </div>
            </div>

            {{-- Imagem/Capa URL --}}
            <div style="margin-bottom: 20px;">
                <label for="imagem" style="display: block; font-weight: 600; margin-bottom: 8px;">URL da Capa ou Imagem</label>
                <input type="url" name="imagem" id="imagem" value="{{ old('imagem') }}" placeholder="https://exemplo.com/imagem.jpg" style="width: 100%; padding: 12px; background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.15); border-radius: 6px; color: #fff;">
            </div>

            {{-- Descrição --}}
            <div style="margin-bottom: 24px;">
                <label for="descricao" style="display: block; font-weight: 600; margin-bottom: 8px;">Descrição do Curso</label>
                <textarea name="descricao" id="descricao" rows="5" placeholder="Descreva o conteúdo do curso, requisitos e o que as alunas vão aprender..." style="width: 100%; padding: 12px; background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.15); border-radius: 6px; color: #fff; font-family: inherit;">{{ old('descricao') }}</textarea>
            </div>

            {{-- Botões de Ação --}}
            <div style="display: flex; gap: 12px; align-items: center; justify-content: flex-end;">
                <a href="{{ route('cursos.index') }}" class="btn btn-ghost">Cancelar</a>
                <button type="submit" class="btn btn-primary">Cadastrar Curso</button>
            </div>
        </form>

    </div>
</section>

@endsection