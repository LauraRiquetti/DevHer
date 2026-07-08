<footer class="site-footer">
    <div class="wrap">
        <div class="footer-grid">
            <div class="footer-brand">
                <a href="{{ url('/') }}" class="logo"><span class="dot"></span>DevHer</a>
                <p>Plataforma de apoio, formação e visibilidade para mulheres na tecnologia. Aprenda, conecte-se e venda seus projetos.</p>
            </div>
            <div class="footer-col">
                <h5>Produto</h5>
                <ul>
                    <li><a href="{{ route('projetos.index') ?? '#' }}">Marketplace</a></li>
                    <li><a href="{{ route('cursos.index') ?? '#' }}">Cursos e mentorias</a></li>
                    <li><a href="{{ url('/#comunidade') }}">Comunidade</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h5>Recursos</h5>
                <ul>
                    <li><a href="{{ url('/#como-funciona') }}">Como funciona</a></li>
                    <li><a href="#">Central de ajuda</a></li>
                    <li><a href="#">Blog</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h5>Legal</h5>
                <ul>
                    <li><a href="#">Termos de uso</a></li>
                    <li><a href="#">Privacidade (LGPD)</a></li>
                    <li><a href="#">Segurança</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <span>&copy; {{ date('Y') }} DevHer. Todos os direitos reservados.</span>
            <span>Feito por mulheres, para mulheres da tecnologia.</span>
        </div>
    </div>
</footer>