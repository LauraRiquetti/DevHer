@extends('layouts.app')

@section('title', 'Criar conta')

@section('content')
<section class="hero" style="padding:0;">
    <div class="glow glow-1"></div>
    <div class="auth-wrap" style="max-width:480px;">
        <div class="form-card reveal in">
            <span class="eyebrow">Junte-se à comunidade</span>
            <h1>Criar sua conta</h1>
            <p class="sub">Leva menos de dois minutos.</p>

            @if ($errors->any())
                <div class="alert alert-error">{{ $errors->first() }}</div>
            @endif

            {{-- RF01: nome completo, e-mail, senha, data de nascimento e tipo de perfil --}}
            <form method="POST" action="{{ route('cadastro.store') ?? '#' }}">
                @csrf

                <div class="field">
                    <label for="name">Nome completo</label>
                    <input type="text" name="name" id="name" placeholder="Seu nome completo" value="{{ old('name') }}" required>
                </div>

                <div class="field">
                    <label for="email">E-mail</label>
                    <input type="email" name="email" id="email" placeholder="voce@email.com" value="{{ old('email') }}" required>
                </div>

                <div class="field-row">
                    <div class="field">
                        <label for="password">Senha</label>
                        <input type="password" name="password" id="password" placeholder="Mínimo 8 caracteres" required>
                    </div>
                    <div class="field">
                        <label for="password_confirmation">Confirmar senha</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Repita a senha" required>
                    </div>
                </div>

                <div class="field">
                    <label for="birthdate">Data de nascimento</label>
                    <input type="date" name="birthdate" id="birthdate" value="{{ old('birthdate') }}" required>
                    <small style="color:var(--muted-2);font-size:12px;display:block;margin-top:6px;">
                        Usada para liberar o acesso a cursos com restrição de idade (18+).
                    </small>
                </div>

                <div class="field">
                    <label>Tipo de perfil</label>
                    <div class="radio-group">
                        <label class="radio-card">
                            <input type="radio" name="tipo_perfil" value="cliente" checked>
                            Cliente<br><span style="color:var(--muted-2);font-size:11.5px;">Quero aprender e comprar</span>
                        </label>
                        <label class="radio-card">
                            <input type="radio" name="tipo_perfil" value="criadora">
                            Criadora<br><span style="color:var(--muted-2);font-size:11.5px;">Quero publicar e vender</span>
                        </label>
                    </div>
                </div>

                <label class="field-check" style="margin-bottom:22px;">
                    <input type="checkbox" name="termos" required>
                    Li e aceito os <a href="#" style="color:var(--pink-light);">termos de uso</a> e a política de privacidade.
                </label>

                <button type="submit" class="btn btn-primary btn-block">Criar minha conta</button>
            </form>

            <div class="form-footer-link">
                Já tem conta? <a href="{{ route('login') ?? '#' }}">Entrar</a>
            </div>
        </div>
    </div>
</section>
@endsection