@extends('layouts.app')

@php
    // Obtém o usuário logado ou a variável $cliente caso ela seja enviada pelo Controller
    $cliente = $cliente ?? Auth::user();
@endphp

@section('title', 'Editar Cliente')

@section('content')

<section class="page-head">
    <div class="wrap">
        <span class="eyebrow">Área do Cliente</span>
        <h1>Editar perfil</h1>
        <p>Atualize os seus dados cadastrais e de endereço.</p>
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

            <form method="POST" action="{{ route('clientes.update', $cliente->id) }}">
                @csrf
                @method('PUT')

                <h3 style="margin-bottom: 16px; font-size: 18px;">Dados Pessoais</h3>
                
                <div class="field-row" style="display: flex; gap: 16px;">
                    <div class="field" style="flex: 1;">
                        <label for="nome">Nome completo</label>
                        <input type="text" name="nome" id="nome" value="{{ old('nome', $cliente->name ?? $cliente->nome) }}" required>
                    </div>
                    <div class="field" style="flex: 1;">
                        <label for="email">E-mail</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $cliente->email) }}" required>
                    </div>
                </div>

                <div class="field-row" style="display: flex; gap: 16px; margin-top: 16px;">
                    <div class="field" style="flex: 1;">
                        <label for="CPF">CPF</label>
                        <input type="text" name="CPF" id="CPF" value="{{ old('CPF', $cliente->CPF) }}">
                    </div>
                    <div class="field" style="flex: 1;">
                        <label for="telefone">Telefone</label>
                        <input type="text" name="telefone" id="telefone" value="{{ old('telefone', $cliente->telefone) }}">
                    </div>
                    <div class="field" style="flex: 1;">
                        <label for="data_nascimento">Data de Nascimento</label>
                        <input type="date" name="data_nascimento" id="data_nascimento" value="{{ old('data_nascimento', $cliente->data_nascimento) }}">
                    </div>
                </div>

                <hr style="margin: 32px 0; border: 0; border-top: 1px solid var(--border-color);">

                <h3 style="margin-bottom: 16px; font-size: 18px;">Endereço</h3>
                
                <div class="field-row" style="display: flex; gap: 16px;">
                    <div class="field" style="flex: 1;">
                        <label for="CEP">CEP</label>
                        <input type="text" name="CEP" id="CEP" value="{{ old('CEP', $cliente->CEP) }}">
                    </div>
                    <div class="field" style="flex: 2;">
                        <label for="rua">Rua</label>
                        <input type="text" name="rua" id="rua" value="{{ old('rua', $cliente->rua) }}">
                    </div>
                    <div class="field" style="width: 100px;">
                        <label for="numero">Número</label>
                        <input type="text" name="numero" id="numero" value="{{ old('numero', $cliente->numero) }}">
                    </div>
                </div>

                <div class="field-row" style="display: flex; gap: 16px; margin-top: 16px;">
                    <div class="field" style="flex: 1;">
                        <label for="bairro">Bairro</label>
                        <input type="text" name="bairro" id="bairro" value="{{ old('bairro', $cliente->bairro) }}">
                    </div>
                    <div class="field" style="flex: 1;">
                        <label for="cidade">Cidade</label>
                        <input type="text" name="cidade" id="cidade" value="{{ old('cidade', $cliente->cidade) }}">
                    </div>
                    <div class="field" style="width: 100px;">
                        <label for="estado">UF</label>
                        <input type="text" name="estado" id="estado" value="{{ old('estado', $cliente->estado) }}" maxlength="2">
                    </div>
                </div>

                <hr style="margin: 32px 0; border: 0; border-top: 1px solid var(--border-color);">

                <h3 style="margin-bottom: 16px; font-size: 18px;">Segurança</h3>

                <div class="field">
                    <label for="password">Nova Senha (opcional)</label>
                    <input type="password" name="password" id="password" placeholder="Deixe em branco para não alterar">
                </div>

                <div style="display:flex; gap:12px; margin-top:32px;">
                    <button type="submit" class="btn btn-primary">Salvar alterações</button>
                    {{-- Corrigido de clientes.index para clientes.show --}}
                    <a href="{{ route('clientes.show', $cliente->id) }}" class="btn btn-ghost" style="padding: 10px 16px; text-decoration: none;">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection