@extends('layouts.app')

@section('title', 'Editar usuário')

@section('content')

@php
    // fallback de exemplo — normalmente virá do controller via route model binding
    $usuario = $usuario ?? ['id' => 1, 'name' => 'Mariana Costa', 'email' => 'mariana@email.com', 'tipo_perfil' => 'criadora', 'status' => 'ativo'];
@endphp

<section class="page-head">
    <div class="wrap">
        <span class="eyebrow">Painel administrativo</span>
        <h1>Editar usuário</h1>
        <p>Atualize os dados ou o status de acesso de {{ $usuario['name'] }}.</p>
    </div>
</section>

<section style="padding:48px 0 100px;">
    <div class="wrap" style="max-width:560px;">
        <div class="card">

            @if ($errors->any())
                <div class="alert alert-error">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('usuarios.update', $usuario['id']) ?? '#' }}">
                @csrf
                @method('PUT')

                <div class="field">
                    <label for="name">Nome completo</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $usuario['name']) }}" required>
                </div>

                <div class="field">
                    <label for="email">E-mail</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $usuario['email']) }}" required>
                </div>

                <div class="field-row">
                    <div class="field">
                        <label for="tipo_perfil">Tipo de perfil</label>
                        <select name="tipo_perfil" id="tipo_perfil">
                            <option value="cliente" {{ $usuario['tipo_perfil'] === 'cliente' ? 'selected' : '' }}>Cliente</option>
                            <option value="criadora" {{ $usuario['tipo_perfil'] === 'criadora' ? 'selected' : '' }}>Criadora</option>
                            <option value="admin" {{ $usuario['tipo_perfil'] === 'admin' ? 'selected' : '' }}>Administradora</option>
                        </select>
                    </div>
                    <div class="field">
                        <label for="status">Status</label>
                        <select name="status" id="status">
                            <option value="ativo" {{ $usuario['status'] === 'ativo' ? 'selected' : '' }}>Ativo</option>
                            <option value="pendente" {{ $usuario['status'] === 'pendente' ? 'selected' : '' }}>Pendente</option>
                            <option value="bloqueado" {{ $usuario['status'] === 'bloqueado' ? 'selected' : '' }}>Bloqueado</option>
                        </select>
                    </div>
                </div>

                <div style="display:flex;gap:12px;margin-top:8px;">
                    <button type="submit" class="btn btn-primary">Salvar alterações</button>
                    <a href="{{ route('usuarios.index') ?? '#' }}" class="btn btn-ghost">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection