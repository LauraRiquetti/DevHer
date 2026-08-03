@extends('Layouts.app')

@section('title', 'Redefinir senha')

@section('content')
<section class="hero" style="padding:0;">
    <div class="glow glow-1"></div>
    <div class="auth-wrap">
        <div class="form-card reveal in">
            <span class="eyebrow">Quase lá</span>
            <h1>Definir nova senha</h1>
            <p class="sub">Escolha uma senha forte, com pelo menos 8 caracteres.</p>

            @if ($errors->any())
                <div class="alert alert-error">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('password.update') ?? '#' }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token ?? '' }}">

                <div class="field">
                    <label for="email">E-mail</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $email ?? '') }}" required autofocus>
                </div>

                <div class="field">
                    <label for="password">Nova senha</label>
                    <input type="password" name="password" id="password" placeholder="••••••••" required>
                </div>

                <div class="field">
                    <label for="password_confirmation">Confirmar nova senha</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Redefinir senha</button>
            </form>
        </div>
    </div>
</section>
@endsection