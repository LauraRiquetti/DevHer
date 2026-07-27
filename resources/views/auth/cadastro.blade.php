@extends('layouts.app')

@section('title', 'Criar conta')

@section('content')
<section class="hero" style="padding:0;">
    <div class="glow glow-1"></div>
    <div class="auth-wrap" style="max-width:560px;">
        <div class="form-card reveal in">
            <span class="eyebrow">Junte-se à comunidade</span>
            <h1>Criar sua conta</h1>
            <p class="sub">Leva menos de dois minutos.</p>

            @if ($errors->any())
                <div class="alert alert-error" style="background:rgba(255,45,135,0.1); border:1px solid #FF2D87; padding:12px; border-radius:6px; margin-bottom:16px; color:#FF2D87;">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('cadastro.store') }}">
                @csrf

                {{-- Tipo de Perfil --}}
                <div class="field" style="margin-bottom:20px;">
                    <label style="font-weight:600; display:block; margin-bottom:8px;">Tipo de perfil *</label>
                    <div class="radio-group" style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                        <label class="radio-card" style="border:1px solid rgba(255,255,255,0.15); padding:12px; border-radius:8px; cursor:pointer;">
                            <input type="radio" name="tipo_perfil" value="cliente" {{ old('tipo_perfil', 'cliente') == 'cliente' ? 'checked' : '' }}>
                            <strong>Cliente</strong><br>
                            <span style="color:var(--muted-2);font-size:11.5px;">Quero aprender e comprar</span>
                        </label>
                        <label class="radio-card" style="border:1px solid rgba(255,255,255,0.15); padding:12px; border-radius:8px; cursor:pointer;">
                            <input type="radio" name="tipo_perfil" value="vendedora" {{ old('tipo_perfil') == 'vendedora' ? 'checked' : '' }}>
                            <strong>Vendedora/Criadora</strong><br>
                            <span style="color:var(--muted-2);font-size:11.5px;">Quero publicar e vender</span>
                        </label>
                    </div>
                </div>

                {{-- Dados Pessoais --}}
                <div class="field">
                    <label for="nome">Nome completo *</label>
                    <input type="text" name="nome" id="nome" placeholder="Seu nome completo" value="{{ old('nome') }}" required>
                </div>

                <div class="field-row" style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                    <div class="field">
                        <label for="email">E-mail *</label>
                        <input type="email" name="email" id="email" placeholder="voce@email.com" value="{{ old('email') }}" required>
                    </div>
                    <div class="field">
                        <label for="telefone">Telefone / WhatsApp *</label>
                        <input type="text" name="telefone" id="telefone" placeholder="(11) 99999-9999" value="{{ old('telefone') }}" required>
                    </div>
                </div>

                <div class="field-row" style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                    <div class="field">
                        <label for="cpf">CPF (somente números) *</label>
                        <input type="text" name="cpf" id="cpf" placeholder="000.000.000-00" value="{{ old('cpf') }}" maxlength="14" required>
                    </div>
                    <div class="field">
                        <label for="data_nascimento">Data de nascimento *</label>
                        <input type="date" name="data_nascimento" id="data_nascimento" value="{{ old('data_nascimento') }}" required>
                    </div>
                </div>

                <div class="field-row" style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                    <div class="field">
                        <label for="password">Senha *</label>
                        <input type="password" name="password" id="password" placeholder="Mínimo 8 caracteres" required>
                    </div>
                    <div class="field">
                        <label for="password_confirmation">Confirmar senha *</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Repita a senha" required>
                    </div>
                </div>

                {{-- Endereço --}}
                <hr style="border-color:rgba(255,255,255,0.08); margin:20px 0;">
                <span class="eyebrow" style="font-size:12px; margin-bottom:8px; display:block;">Endereço de cobrança</span>

                <div class="field-row" style="display:grid; grid-template-columns:1fr 2fr; gap:12px;">
                    <div class="field">
                        <label for="cep">CEP *</label>
                        <input type="text" name="cep" id="cep" placeholder="00000-000" value="{{ old('cep') }}" required>
                    </div>
                    <div class="field">
                        <label for="rua">Rua/Logradouro *</label>
                        <input type="text" name="rua" id="rua" placeholder="Rua..." value="{{ old('rua') }}" required>
                    </div>
                </div>

                <div class="field-row" style="display:grid; grid-template-columns:1fr 2fr; gap:12px;">
                    <div class="field">
                        <label for="numero">Número *</label>
                        <input type="number" name="numero" id="numero" placeholder="123" value="{{ old('numero') }}" required>
                    </div>
                    <div class="field">
                        <label for="bairro">Bairro *</label>
                        <input type="text" name="bairro" id="bairro" placeholder="Bairro" value="{{ old('bairro') }}" required>
                    </div>
                </div>

                <div class="field-row" style="display:grid; grid-template-columns:2fr 1fr; gap:12px;">
                    <div class="field">
                        <label for="cidade">Cidade *</label>
                        <input type="text" name="cidade" id="cidade" placeholder="Cidade" value="{{ old('cidade') }}" required>
                    </div>
                    <div class="field">
                        <label for="estado">UF *</label>
                        <input type="text" name="estado" id="estado" placeholder="SP" maxlength="2" value="{{ old('estado') }}" required style="text-transform:uppercase;">
                    </div>
                </div>

                <label class="field-check" style="margin:20px 0;">
                    <input type="checkbox" name="termos" required>
                    Li e aceito os <a href="#" style="color:var(--pink-light);">termos de uso</a> e a política de privacidade.
                </label>

                <button type="submit" class="btn btn-primary btn-block">Criar minha conta</button>
            </form>

            <div class="form-footer-link" style="margin-top:16px; text-align:center;">
                Já tem conta? <a href="{{ route('login') }}">Entrar</a>
            </div>
        </div>
    </div>
</section>
@push('scripts')
    <script src="{{ asset('js/via-cep.js') }}"></script>
@endpush
@endsection