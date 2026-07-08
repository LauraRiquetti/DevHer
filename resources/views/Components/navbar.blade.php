<header class="site-header">
    <nav class="navbar">
        <a href="{{ url('/') }}" class="logo"><span class="dot"></span>DevHer</a>

        <ul class="nav-links">
            <li><a href="{{ url('/#comunidade') }}">Comunidade</a></li>
            <li><a href="{{ route('cursos.index') ?? '#' }}">Cursos</a></li>
            <li><a href="{{ route('projetos.index') ?? '#' }}">Marketplace</a></li>
            <li><a href="{{ url('/#como-funciona') }}">Como funciona</a></li>
            <li><a href="{{ url('/#planos') }}">Planos</a></li>
        </ul>

        <div class="nav-cta">
            {{-- @auth / @guest exigem o sistema de autenticação do Laravel configurado --}}
            @auth
                <div class="nav-user">
                    <div class="avatar-sm"></div>
                    <span>{{ Auth::user()->name }}</span>
                </div>
                <form action="{{ route('logout') ?? '#' }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-ghost btn-sm">Sair</button>
                </form>
            @else
                <a href="{{ route('login') ?? '#' }}" class="btn btn-ghost" style="padding:10px 18px;">Entrar</a>
                <a href="{{ route('cadastro') ?? '#' }}" class="btn btn-primary" style="padding:10px 20px;">Criar conta</a>
            @endauth
        </div>

        <button class="nav-toggle" aria-label="Abrir menu">☰</button>
    </nav>
</header>