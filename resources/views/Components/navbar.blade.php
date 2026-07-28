<header class="site-header">
    <nav class="navbar">
        <a href="{{ url('/') }}" class="logo"><span class="dot"></span>DevHer</a>

        <ul class="nav-links">
            <li><a href="{{ url('/#comunidade') }}">Comunidade</a></li>
            <li><a href="{{ route('cursos.index') ?? '#' }}">Cursos</a></li>
            <li><a href="{{ route('projetos.index') ?? '#' }}">Marketplace</a></li>
            <li><a href="{{ url('/#como-funciona') }}">Como funciona</a></li>
            <li><a href="{{ url('/#jornada') }}">Comece sua jornada</a></li>
        </ul>

        <div class="nav-cta">
            {{-- Se o usuário estiver autenticado no sistema --}}
            @auth
                <div class="nav-user" style="display: flex; align-items: center; gap: 10px; margin-right: 10px;">
                    <div class="avatar-sm" style="width: 32px; height: 32px; background-color: var(--pink-light, #e83e8c); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <span style="font-weight: 600;">Olá, {{ Auth::user()->name }}</span>
                </div>

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