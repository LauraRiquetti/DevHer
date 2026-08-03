{{-- Estende o layout principal da aplicação --}}
@extends('layouts.app')

{{-- Define o título da página na aba do navegador --}}
@section('title', 'Criar conta')

@section('content')
<section class="hero" style="padding:0;">
    <!-- Efeito de brilho ao fundo da tela -->
    <div class="glow glow-1"></div>
    
    <!-- Container do formulário de cadastro (mais largo que o de login) -->
    <div class="auth-wrap" style="max-width:560px;">
        <div class="form-card reveal in">
            <!-- Textos de introdução -->
            <span class="eyebrow">Junte-se à comunidade</span>
            <h1>Criar sua conta</h1>
            <p class="sub">Leva menos de dois minutos.</p>

            {{-- Exibe o primeiro erro de validação (ex: e-mail já cadastrado, CPF inválido) --}}
            @if ($errors->any())
                <div class="alert alert-error" style="background:rgba(255,45,135,0.1); border:1px solid #FF2D87; padding:12px; border-radius:6px; margin-bottom:16px; color:#FF2D87;">
                    {{ $errors->first() }}
                </div>
            @endif

            <!-- Início do Formulário de Cadastro -->
            <form method="POST" action="{{ route('cadastro.store') }}">
                {{-- Token CSRF: Proteção obrigatória do Laravel --}}
                @csrf

                {{-- Tipo de Perfil: Seleção entre Cliente ou Vendedora --}}
                <div class="field" style="margin-bottom:20px;">
                    <label style="font-weight:600; display:block; margin-bottom:8px;">Tipo de perfil *</label>
                    
                    <!-- Grid para colocar os dois cartões de rádio lado a lado -->
                    <div class="radio-group" style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                        <!-- Opção: Cliente -->
                        <label class="radio-card" style="border:1px solid rgba(255,255,255,0.15); padding:12px; border-radius:8px; cursor:pointer;">
                            {{-- old('tipo_perfil') mantém a seleção caso a página recarregue com erro --}}
                            <input type="radio" name="tipo_perfil" value="cliente" {{ old('tipo_perfil', 'cliente') == 'cliente' ? 'checked' : '' }}>
                            <strong>Cliente</strong><br>
                            <span style="color:var(--muted-2);font-size:11.5px;">Quero aprender e comprar</span>
                        </label>
                        
                        <!-- Opção: Vendedora -->
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

                <!-- Agrupamento de E-mail e Telefone na mesma linha -->
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

                <!-- Agrupamento de CPF e Data de Nascimento na mesma linha -->
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

                {{-- Campos de Senha (com funcionalidade de mostrar/ocultar) --}}
                <div class="field-row" style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                    <!-- Senha Principal -->
                    <div class="field">
                        <label for="password">Senha *</label>
                        <div style="position: relative;">
                            <input type="password" name="password" id="password" placeholder="Mínimo 8 caracteres" required style="padding-right: 40px; width: 100%;">
                            <button type="button" onclick="togglePassword('password', this)" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: transparent; border: none; cursor: pointer; color: var(--muted-2); padding: 0; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-toggle-off" style="font-size: 1.2rem;"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Confirmação de Senha -->
                    <div class="field">
                        <label for="password_confirmation">Confirmar senha *</label>
                        <div style="position: relative;">
                            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Repita a senha" required style="padding-right: 40px; width: 100%;">
                            <button type="button" onclick="togglePassword('password_confirmation', this)" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: transparent; border: none; cursor: pointer; color: var(--muted-2); padding: 0; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-toggle-off" style="font-size: 1.2rem;"></i>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Endereço --}}
                <!-- Linha divisória para separar os dados de endereço visualmente -->
                <hr style="border-color:rgba(255,255,255,0.08); margin:20px 0;">
                <span class="eyebrow" style="font-size:12px; margin-bottom:8px; display:block;">Endereço de cobrança</span>

                <!-- Agrupamento CEP (menor) e Rua (maior) -->
                <div class="field-row" style="display:grid; grid-template-columns:1fr 2fr; gap:12px;">
                    <div class="field">
                        <label for="cep">CEP *</label>
                        <input type="text" name="cep" id="cep" placeholder="00000-000" value="{{ old('cep') }}" required>
                        {{-- Mensagem de erro que será exibida pelo JS --}}
                        <small id="cep-error" style="color: #FF2D87; display: none; margin-top: 4px; font-weight: 500;">
                            CEP não encontrado.
                        </small>
                    </div>
                    <div class="field">
                        <label for="rua">Rua/Logradouro *</label>
                        <input type="text" name="rua" id="rua" placeholder="Rua..." value="{{ old('rua') }}" required>
                    </div>
                </div>

                <!-- Agrupamento Número (menor) e Bairro (maior) -->
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

                <!-- Agrupamento Cidade (maior) e Estado (menor) -->
                <div class="field-row" style="display:grid; grid-template-columns:2fr 1fr; gap:12px;">
                    <div class="field">
                        <label for="cidade">Cidade *</label>
                        <input type="text" name="cidade" id="cidade" placeholder="Cidade" value="{{ old('cidade') }}" required>
                    </div>
                    <div class="field">
                        <label for="estado">UF *</label>
                        <!-- text-transform força a exibição em maiúsculas (ex: SP, MG) -->
                        <input type="text" name="estado" id="estado" placeholder="SP" maxlength="2" value="{{ old('estado') }}" required style="text-transform:uppercase;">
                    </div>
                </div>

                <!-- Aceite de Termos -->
                <label class="field-check" style="margin:20px 0;">
                    <input type="checkbox" name="termos" required>
                    Li e aceito os <a href="#" style="color:var(--pink-light);">termos de uso</a> e a política de privacidade.
                </label>

                <!-- Botão de Submissão -->
                <button type="submit" class="btn btn-primary btn-block">Criar minha conta</button>
            </form>

            <!-- Link para voltar ao Login -->
            <div class="form-footer-link" style="margin-top:16px; text-align:center;">
                Já tem conta? <a href="{{ route('login') }}">Entrar</a>
            </div>
        </div>
    </div>
</section>

{{-- Injeta o script de preenchimento automático do ViaCEP no final da página (layout) --}}
@push('scripts')
    <script src="{{ asset('js/via-cep.js') }}"></script>
@endpush
@endsection