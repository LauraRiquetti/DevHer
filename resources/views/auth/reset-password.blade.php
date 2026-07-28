@extends('layouts.app')

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
                    <div style="position: relative;">
                        <input type="password" name="password" id="password" placeholder="••••••••" required style="padding-right: 40px; width: 100%;">
                        <button type="button" onclick="togglePassword('password', this)" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: transparent; border: none; cursor: pointer; color: var(--muted-2); padding: 0; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-toggle-off" style="font-size: 1.2rem;"></i>
                        </button>
                    </div>
                </div>

                <div class="field">
                    <label for="password_confirmation">Confirmar nova senha</label>
                    <div style="position: relative;">
                        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="••••••••" required style="padding-right: 40px; width: 100%;">
                        <button type="button" onclick="togglePassword('password_confirmation', this)" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: transparent; border: none; cursor: pointer; color: var(--muted-2); padding: 0; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-toggle-off" style="font-size: 1.2rem;"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Redefinir senha</button>
            </form>
        </div>
    </div>
</section>
@endsection