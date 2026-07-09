@extends('layouts.app')

@section('title', 'Recuperar senha')

@section('content')
<section class="hero" style="padding:0;">
    <div class="glow glow-1"></div>
    <div class="auth-wrap">
        <div class="form-card reveal in">
            <span class="eyebrow">Sem problemas</span>
            <h1>Esqueceu a senha?</h1>
            <p class="sub">Informe seu e-mail e enviaremos um link para redefinir sua senha.</p>

            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-error">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('password.email') ?? '#' }}">
                @csrf
                <div class="field">
                    <label for="email">E-mail</label>
                    <input type="email" name="email" id="email" placeholder="voce@email.com" value="{{ old('email') }}" required autofocus>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Enviar link de recuperação</button>
            </form>

            <div class="form-footer-link">
                Lembrou a senha? <a href="{{ route('login') ?? '#' }}">Voltar para o login</a>
            </div>
        </div>
    </div>
</section>
@endsection