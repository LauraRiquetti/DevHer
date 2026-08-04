<header class="site-header">
    <nav class="navbar">
        <a href="{{ url('/') }}" class="logo">
            {{-- Persona/mascote do DevHer, ao lado do nome, igual ao site da Magalu --}}
            <img src="{{ asset('images/persona-devher.png') }}" alt="Persona DevHer" class="logo-persona">
            <span class="dot"></span>DevHer
        </a>
        <ul class="nav-links">
            <li><a href="{{ url('/#comunidade') }}">Comunidade</a></li>
            <li><a href="{{ route('cursos.index') ?? '#' }}">Cursos</a></li>
            <li><a href="{{ route('projetos.index') ?? '#' }}">Marketplace</a></li>
            <li><a href="{{ url('/#como-funciona') }}">Como funciona</a></li>
            <li><a href="{{ url('/#jornada') }}">Comece sua jornada</a></li>
        </ul>
        <div class="nav-cta" style="display: flex; align-items: center; gap: 15px;">
            
            {{-- Ícone do Carrinho de Compras --}}
            <a href="{{ route('carrinho.index') }}" class="nav-cart-link" style="position: relative; display: flex; align-items: center; color: inherit; text-decoration: none; font-size: 1.4rem;">
                <i class="bi bi-cart4"></i>
                @if(session('carrinho') && count(session('carrinho')) > 0)
                    <span class="badge" style="position: absolute; top: -6px; right: -10px; background-color: var(--pink-light, #e83e8c); color: #fff; border-radius: 50%; width: 18px; height: 18px; font-size: 0.75rem; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                        {{ count(session('carrinho')) }}
                    </span>
                @endif
            </a>
            {{-- Se o usuário estiver autenticado no sistema --}}
            @auth
                {{-- Link dinâmico: Verifica se a role é 'vendedora' para mandar para a rota certa --}}
                <a href="{{ Auth::user()->role === 'vendedora' ? route('criadoras.show', Auth::user()->id) : route('clientes.show', Auth::user()->id) }}" class="nav-user" style="display: flex; align-items: center; gap: 10px; text-decoration: none; color: inherit; cursor: pointer;">
                    
                    <div class="avatar-sm" style="width: 32px; height: 32px; background-color: var(--pink-light, #e83e8c); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    
                    {{-- Efeito hover simples para mostrar que é clicável --}}
                    <span style="font-weight: 600;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                        Olá, {{ Auth::user()->name }}
                    </span>
                </a>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-ghost btn-sm">Sair</button>
                </form>
            {{-- Se for um visitante não logado --}}
            @else
                <a href="{{ route('login') }}" class="btn btn-ghost" style="padding:10px 18px;">Entrar</a>
                <a href="{{ route('cadastro') }}" class="btn btn-primary" style="padding:10px 20px;">Criar conta</a>
            @endauth
        </div>
        <button class="nav-toggle" aria-label="Abrir menu">☰</button>
    </nav>
</header>

{{-- Estilo da persona no logo, escopado só ao cabeçalho para não afetar o .logo do rodapé --}}
<style>
    .site-header .logo {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .site-header .logo-persona {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        object-fit: cover;
        display: block;
        flex-shrink: 0;
    }
</style>