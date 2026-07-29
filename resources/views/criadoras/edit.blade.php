@extends('layouts.app')

@section('title', 'Editar Criadora')

@section('content')

@php
    // Fallback de exemplo
    $criadora = $criadora ?? (object)[
        'id' => 1, 'nome' => 'Alice Ferreira', 'email' => 'alice@email.com', 
        'telefone' => '(11) 98888-8888', 'CPF_CNPJ' => '111.111.111-11', 
        'chave_pix' => 'alice@email.com', 'comissao' => 15, 'status' => 'Ativa'
    ];
@endphp

<section class="page-head">
    <div class="wrap">
        <span class="eyebrow">Administração / Criadoras</span>
        <h1>Editar: {{ $criadora->nome }}</h1>
        <p>Ajuste os dados cadastrais, financeiros e o status dessa vendedora.</p>
    </div>
</section>

<section style="padding:48px 0 100px;">
    <div class="wrap" style="max-width:760px;">
        <div class="card">

            @if ($errors->any())
                <div class="alert alert-error" style="margin-bottom: 24px; color: red;">
                    <ul style="padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('criadoras.update', $criadora->id) }}">
                @csrf
                @method('PUT')

                <h3 style="margin-bottom: 16px; font-size: 18px;">Dados Pessoais / Empresariais</h3>
                
                <div class="field-row" style="display: flex; gap: 16px;">
                    <div class="field" style="flex: 1;">
                        <label for="nome">Nome / Razão Social</label>
                        <input type="text" name="nome" id="nome" value="{{ old('nome', $criadora->nome) }}" required>
                    </div>
                    <div class="field" style="flex: 1;">
                        <label for="email">E-mail de Contato</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $criadora->email) }}" required>
                    </div>
                </div>

                <div class="field-row" style="display: flex; gap: 16px;">
                    <div class="field" style="flex: 1;">
                        <label for="CPF_CNPJ">CPF / CNPJ</label>
                        <input type="text" name="CPF_CNPJ" id="CPF_CNPJ" value="{{ old('CPF_CNPJ', $criadora->CPF_CNPJ) }}" required>
                    </div>
                    <div class="field" style="flex: 1;">
                        <label for="telefone">Telefone</label>
                        <input type="text" name="telefone" id="telefone" value="{{ old('telefone', $criadora->telefone) }}" required>
                    </div>
                </div>

                <hr style="margin: 32px 0; border: 0; border-top: 1px solid var(--border-color);">

                <h3 style="margin-bottom: 16px; font-size: 18px;">Dados Financeiros e Sistema</h3>
                
                <div class="field-row" style="display: flex; gap: 16px;">
                    <div class="field" style="flex: 2;">
                        <label for="chave_pix">Chave PIX (Para repasses)</label>
                        <input type="text" name="chave_pix" id="chave_pix" value="{{ old('chave_pix', $criadora->chave_pix) }}">
                    </div>
                    <div class="field" style="flex: 1;">
                        <label for="comissao">Taxa da Plataforma (%)</label>
                        <input type="number" step="0.01" name="comissao" id="comissao" value="{{ old('comissao', $criadora->comissao) }}" required>
                    </div>
                </div>

                <div class="field-row" style="display: flex; gap: 16px; margin-top: 16px;">
                    <div class="field" style="flex: 1;">
                        <label for="status">Status da Conta</label>
                        <select name="status" id="status" style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 4px;">
                            <option value="Ativa" {{ old('status', $criadora->status) == 'Ativa' ? 'selected' : '' }}>Ativa (Pode vender)</option>
                            <option value="Inativa" {{ old('status', $criadora->status) == 'Inativa' ? 'selected' : '' }}>Inativa (Bloqueada/Suspensa)</option>
                        </select>
                    </div>
                    <div class="field" style="flex: 1;">
                        <label for="password">Redefinir Senha (opcional)</label>
                        <input type="password" name="password" id="password" placeholder="Deixe em branco para manter">
                    </div>
                </div>

                <div style="display:flex;gap:12px;margin-top:32px;">
                    <button type="submit" class="btn btn-primary">Salvar alterações</button>
                    <a href="{{ route('criadoras.index') }}" class="btn btn-ghost" style="padding: 10px 16px; text-decoration: none;">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection