{{-- Estende o layout principal da aplicação (localizado em resources/views/layouts/app.blade.php) --}}
@extends('layouts.app')

{{-- Define o título que aparecerá na aba do navegador --}}
@section('title', 'Entrar')

{{-- Inicia a seção de conteúdo que será injetada no layout principal --}}
@section('content')
<section class="hero" style="padding:0;">
    
    {{-- Exibe uma mensagem de sucesso, caso exista na sessão (ex: quando a usuária redefine a senha com sucesso) --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Elementos visuais (efeito de brilho no fundo) -->
    <div class="glow glow-1"></div>
    
    <!-- Container que centraliza o formulário na tela -->
    <div class="auth-wrap">
        <div class="form-card reveal in">
            
            <!-- Cabeçalho e textos de boas-vindas -->
            <span class="eyebrow">Bem-vinda de volta</span>
            <h1>Entrar na sua conta</h1>
            <p class="sub">Acesse seus cursos, projetos e sua comunidade.</p>

            {{-- Exibe mensagens de status genéricas retornadas pelo backend --}}
            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif
            
            {{-- Exibe o primeiro erro de validação retornado, caso o login falhe (ex: senha incorreta) --}}
            @if ($errors->any())
                <div class="alert alert-error">{{ $errors->first() }}</div>
            @endif

            <!-- Início do Formulário de Login -->
            <form method="POST" action="{{ route('login') ?? '#' }}">
                {{-- Token CSRF: Medida de segurança obrigatória do Laravel para evitar ataques de falsificação de requisição --}}
                @csrf

                <!-- Campo de E-mail -->
                <div class="field">
                    <label for="email">E-mail</label>
                    {{-- O helper "old('email')" mantém o que a usuária digitou caso a página recarregue devido a um erro --}}
                    <input type="email" name="email" id="email" placeholder="voce@email.com" value="{{ old('email') }}" required autofocus>
                </div>

                <!-- Campo de Senha -->
                <div class="field">
                    <label for="password">Senha</label>
                    {{-- Div com position relative serve como âncora para o botão do ícone flutuante --}}
                    <div style="position: relative;">
                        <!-- Adicionado padding-right para o texto não encostar no ícone -->
                        <input type="password" name="password" id="password" placeholder="••••••••" required style="padding-right: 40px; width: 100%;">
                        
                        <!-- Botão com o ícone: Chama a função JS "togglePassword" ao ser clicado -->
                        <button type="button" onclick="togglePassword('password', this)" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: transparent; border: none; cursor: pointer; color: var(--muted-2); padding: 0; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-toggle-off" style="font-size: 1.2rem;"></i>
                        </button>
                    </div>
                </div>

                <!-- Rodapé do form: Checkbox "Lembrar de mim" e link de "Esqueci a senha" -->
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
                    <label class="field-check">
                        <input type="checkbox" name="remember"> Lembrar de mim
                    </label>
                    <a href="{{ route('password.request') ?? '#' }}" style="font-size:13px;color:var(--pink-light);">Esqueci a senha</a>
                </div>

                <!-- Botão principal para submeter o formulário -->
                <button type="submit" class="btn btn-primary btn-block">Entrar</button>
            </form>

            <!-- Link de redirecionamento para a página de Cadastro -->
            <div class="form-footer-link">
                Ainda não tem conta? <a href="{{ route('cadastro') ?? '#' }}">Criar conta grátis</a>
            </div>
        </div>
    </div>
</section>
@endsection