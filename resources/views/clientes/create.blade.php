@extends('Layouts.app')

@section('title', 'Novo usuário')

@section('content')

<section class="page-head">
    <div class="wrap">
        <span class="eyebrow">Painel administrativo</span>
        <h1>Novo usuário</h1>
        <p>Cadastre manualmente um novo usuário na plataforma.</p>
    </div>
</section>

<section style="padding:48px 0 100px;">
    <div class="wrap" style="max-width:560px;">
        <div class="card">

            @if ($errors->any())
                <div class="alert alert-error">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('usuarios.store') ?? '#' }}">
                @csrf

                <div class="field">
                    <label for="name">Nome completo</label>
                    <input type="text" name="name" id="name" required>
                </div>

                <div class="field">
                    <label for="email">E-mail</label>
                    <input type="email" name="email" id="email" required>
                </div>

                <div class="field-row">
                    <div class="field">
                        <label for="birthdate">Data de nascimento</label>
                        <input type="date" name="birthdate" id="birthdate" required>
                    </div>
                    <div class="field">
                        <label for="tipo_perfil">Tipo de perfil</label>
                        <select name="tipo_perfil" id="tipo_perfil" required>
                            <option value="cliente">Cliente</option>
                            <option value="criadora">Criadora</option>
                            <option value="admin">Administradora</option>
                        </select>
                    </div>
                </div>

                <div class="field">
                    <label for="password">Senha provisória</label>
                    <input type="password" name="password" id="password" required>
                </div>

                <div style="display:flex;gap:12px;margin-top:8px;">
                    <button type="submit" class="btn btn-primary">Cadastrar usuário</button>
                    <a href="{{ route('usuarios.index') ?? '#' }}" class="btn btn-ghost">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection