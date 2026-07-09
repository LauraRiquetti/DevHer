@extends('Layouts.app')

@section('title', 'Criar conta')

@section('content')
<section class="hero" style="padding:0;">
    <div class="glow glow-1"></div>
    <div class="auth-wrap" style="max-width:560px;">
        <div class="form-card reveal in">
            <span class="eyebrow">Junte-se à comunidade</span>
            <h1>Criar sua conta</h1>
            <p class="sub">Preencha seus dados para começar a publicar e vender.</p>

            @if ($errors->any())
                <div class="alert alert-error">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('vendedoras.store') ?? url('/cadastro') }}">
                @csrf

                <div class="field">
                    <label for="nome">Nome completo</label>
                    <input type="text" name="nome" id="nome" placeholder="Seu nome completo" value="{{ old('nome') }}" required>
                </div>

                <div class="field">
                    <label for="email">E-mail</label>
                    <input type="email" name="email" id="email" placeholder="voce@email.com" value="{{ old('email') }}" required>
                </div>

                <div class="field-row">
                    <div class="field">
                        <label for="password">Senha</label>
                        <input type="password" name="password" id="password" placeholder="Mínimo 6 caracteres" required>
                    </div>
                    <div class="field">
                        <label for="data_nascimento">Data de nascimento</label>
                        <input type="date" name="data_nascimento" id="data_nascimento" value="{{ old('data_nascimento') }}" required>
                    </div>
                </div>

                <div class="field">
                    <label for="CEP">CEP</label>
                    <div style="display:flex;gap:10px;">
                        <input type="text" name="CEP" id="CEP" placeholder="00000-000" value="{{ old('CEP') }}" required maxlength="9">
                        <button type="button" id="buscar-cep" class="btn btn-ghost btn-sm" style="white-space:nowrap;">Buscar CEP</button>
                    </div>
                    <small id="cep-status" style="color:var(--muted-2);font-size:12px;display:block;margin-top:6px;"></small>
                </div>

                <div class="field-row">
                    <div class="field">
                        <label for="rua">Rua</label>
                        <input type="text" name="rua" id="rua" placeholder="Nome da rua" value="{{ old('rua') }}" required>
                    </div>
                    <div class="field">
                        <label for="numero">Número</label>
                        <input type="text" name="numero" id="numero" placeholder="Nº" value="{{ old('numero') }}" required>
                    </div>
                </div>

                <div class="field-row">
                    <div class="field">
                        <label for="bairro">Bairro</label>
                        <input type="text" name="bairro" id="bairro" placeholder="Bairro" value="{{ old('bairro') }}" required>
                    </div>
                    <div class="field">
                        <label for="cidade">Cidade</label>
                        <input type="text" name="cidade" id="cidade" placeholder="Cidade" value="{{ old('cidade') }}" required>
                    </div>
                </div>

                <div class="field">
                    <label for="estado">Estado</label>
                    <input type="text" name="estado" id="estado" placeholder="UF" maxlength="2" value="{{ old('estado') }}" required style="max-width:100px;">
                </div>

                <button type="submit" class="btn btn-primary btn-block" style="margin-top:8px;">Criar minha conta</button>
            </form>

            <div class="form-footer-link">
                Já tem conta? <a href="{{ route('login') }}">Entrar</a>
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
document.getElementById('buscar-cep').addEventListener('click', async function () {
    const cepInput = document.getElementById('CEP');
    const status = document.getElementById('cep-status');
    const cep = cepInput.value.replace(/\D/g, '');

    if (cep.length !== 8) {
        status.textContent = 'Digite um CEP válido (8 dígitos).';
        status.style.color = '#FF8F8F';
        return;
    }

    status.textContent = 'Buscando endereço...';
    status.style.color = 'var(--muted-2)';

    try {
        // Rota que chama o VendedoraController::buscarCep($cep)
        const resp = await fetch(`/cep/${cep}`);
        const dados = await resp.json();

        if (dados.erro) {
            status.textContent = 'CEP não encontrado.';
            status.style.color = '#FF8F8F';
            return;
        }

        document.getElementById('rua').value = dados.logradouro || '';
        document.getElementById('bairro').value = dados.bairro || '';
        document.getElementById('cidade').value = dados.localidade || '';
        document.getElementById('estado').value = dados.uf || '';
        status.textContent = 'Endereço preenchido automaticamente.';
        status.style.color = '#7CFFB2';
    } catch (e) {
        status.textContent = 'Não foi possível buscar o CEP agora.';
        status.style.color = '#FF8F8F';
    }
});
</script>
@endsection