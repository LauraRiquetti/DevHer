@extends('Layouts.app')

@section('title', 'Entrar')

@section('content')
<section class="hero" style="padding:0;">
    <div class="glow glow-1"></div>
    <div class="auth-wrap">
        <div class="form-card reveal in">
            <span class="eyebrow">Bem-vinda de volta</span>
            <h1>Entrar na sua conta</h1>
            <p class="sub">Acesse seus cursos, projetos e sua comunidade.</p>

            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-error">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('login') ?? '#' }}">
                @csrf

                <div class="field">
                    <label for="email">E-mail</label>
                    <input type="email" name="email" id="email" placeholder="voce@email.com" value="{{ old('email') }}" required autofocus>
                </div>

                <div class="field">
                    <label for="password">Senha</label>
                    <input type="password" name="password" id="password" placeholder="••••••••" required>
                </div>

                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
                    <label class="field-check">
                        <input type="checkbox" name="remember"> Lembrar de mim
                    </label>
                    <a href="{{ route('password.request') ?? '#' }}" style="font-size:13px;color:var(--pink-light);">Esqueci a senha</a>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Entrar</button>
            </form>

            <div class="form-footer-link">
                Ainda não tem conta? <a href="{{ route('cadastro') ?? '#' }}">Criar conta grátis</a>
            </div>
        </div>
    </div>
</section>
@endsection