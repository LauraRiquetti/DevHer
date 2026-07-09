@extends('layouts.app')

@section('title', 'Início')

@section('content')

<section class="hero">
    <div class="glow glow-1"></div>
    <div class="glow glow-2"></div>
    <div class="wrap hero-inner">
        <span class="eyebrow">Feito por, com e para mulheres da tecnologia</span>
        <h1>Aprenda, conecte-se e <span class="accent">venda seus projetos</span> em tecnologia.</h1>
        <p>Cursos, mentorias, portfólio e uma comunidade real de mulheres na TI — em um único ecossistema pensado para reduzir a evasão feminina e abrir portas no mercado.</p>
        <div class="hero-ctas">
            <a href="{{ route('cadastro') ?? '#' }}" class="btn btn-primary">Comece grátis</a>
            <a href="#como-funciona" class="btn btn-ghost">Ver como funciona</a>
        </div>
    </div>

    <div class="wrap">
        <div class="constellation reveal">
            <svg viewBox="0 0 920 380" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <radialGradient id="nodeGrad" cx="50%" cy="50%" r="60%">
                        <stop offset="0%" stop-color="#FF9AC7"/>
                        <stop offset="100%" stop-color="#FF2D87"/>
                    </radialGradient>
                </defs>
                <g stroke="rgba(255,45,135,0.28)" stroke-width="1">
                    <line x1="150" y1="90" x2="330" y2="150"/>
                    <line x1="330" y1="150" x2="520" y2="80"/>
                    <line x1="330" y1="150" x2="470" y2="260"/>
                    <line x1="470" y1="260" x2="650" y2="200"/>
                    <line x1="650" y1="200" x2="800" y2="110"/>
                    <line x1="470" y1="260" x2="620" y2="320"/>
                    <line x1="150" y1="90" x2="230" y2="260"/>
                    <line x1="230" y1="260" x2="470" y2="260"/>
                    <line x1="520" y1="80" x2="650" y2="200"/>
                    <line x1="800" y1="110" x2="720" y2="60"/>
                </g>
                <g>
                    <circle cx="150" cy="90" r="7" fill="url(#nodeGrad)"/>
                    <circle cx="330" cy="150" r="10" fill="url(#nodeGrad)"/>
                    <circle cx="520" cy="80" r="6" fill="url(#nodeGrad)"/>
                    <circle cx="470" cy="260" r="9" fill="url(#nodeGrad)"/>
                    <circle cx="650" cy="200" r="7" fill="url(#nodeGrad)"/>
                    <circle cx="800" cy="110" r="6" fill="url(#nodeGrad)"/>
                    <circle cx="620" cy="320" r="6" fill="url(#nodeGrad)"/>
                    <circle cx="230" cy="260" r="6" fill="url(#nodeGrad)"/>
                    <circle cx="720" cy="60" r="5" fill="url(#nodeGrad)"/>
                </g>
                <g class="node-label">
                    <text x="330" y="130">@mariana.dev</text>
                    <text x="470" y="245">@ana.backend</text>
                    <text x="650" y="185">@lu.uxui</text>
                    <text x="150" y="75">@bia.data</text>
                    <text x="800" y="95">@carol.sec</text>
                </g>
            </svg>
        </div>
    </div>
</section>

<section class="apoio">
    <div class="wrap">
        <p>Redes e iniciativas que caminham com a gente</p>
        <div class="apoio-row">
            <span class="chip">PyLadies</span>
            <span class="chip">Women Techmakers</span>
            <span class="chip">Meninas Digitais</span>
            <span class="chip">ProgramAdas</span>
            <span class="chip">Rails Girls</span>
            <span class="chip">Marias da Tech</span>
        </div>
    </div>
</section>

<section class="feature" id="marketplace">
    <div class="wrap">
        <div class="feature-copy reveal">
            <span class="eyebrow">Marketplace de projetos</span>
            <h2>Transforme seu portfólio em renda.</h2>
            <p>Publique projetos com título, descrição, categoria e preço. Quem visita filtra, compara e compra com pagamento integrado — direto para o bolso de quem criou.</p>
            <div class="feature-tags">
                <span class="tag">CARRINHO E CHECKOUT</span>
                <span class="tag">FILTRO POR CATEGORIA</span>
                <span class="tag">PAGAMENTO INTEGRADO</span>
            </div>
        </div>
        <div class="mock reveal">
            <div class="mock-bar"><span></span><span></span><span></span></div>
            <div class="mock-title">marketplace / projetos em alta</div>
            <div class="proj-grid">
                <div class="proj-card"><div class="proj-thumb"></div><h4>Dashboard financeiro em React</h4><span class="price">R$ 89,00</span></div>
                <div class="proj-card"><div class="proj-thumb"></div><h4>API de agendamento em Node</h4><span class="price">R$ 120,00</span></div>
            </div>
        </div>
    </div>
</section>

<section class="feature reverse" id="cursos">
    <div class="wrap">
        <div class="feature-copy reveal">
            <span class="eyebrow">Cursos e mentorias</span>
            <h2>Aprenda no seu ritmo, com quem já passou pelo caminho.</h2>
            <p>Video-aulas, workshops e mentorias publicadas por criadoras da própria comunidade. Cursos com temas sensíveis exigem confirmação de maioridade, verificada pela data de nascimento no cadastro.</p>
            <div class="feature-tags">
                <span class="tag">VÍDEO-AULAS</span>
                <span class="tag">MENTORIAS AO VIVO</span>
                <span class="tag">VERIFICAÇÃO DE IDADE</span>
            </div>
        </div>
        <div class="mock reveal">
            <div class="mock-bar"><span></span><span></span><span></span></div>
            <div class="mock-title">cursos / recomendados para você</div>
            <div class="course-row">
                <div class="course-thumb">01</div>
                <div><h4>Lógica de programação do zero</h4><span>Gratuito · 4h</span></div>
            </div>
            <div class="course-row">
                <div class="course-thumb">02</div>
                <div><h4>Segurança ofensiva na prática</h4><span>R$ 149,00 · 8h</span></div>
                <span class="badge-18">18+</span>
            </div>
        </div>
    </div>
</section>

<section class="stats">
    <div class="wrap">
        <h2 class="reveal">Cada número representa uma trajetória que continuou.</h2>
        <div class="stats-grid">
            <div class="reveal"><div class="stat-num" data-count="18">0</div><div class="stat-label">representatividade feminina na TI hoje*</div></div>
            <div class="reveal"><div class="stat-num" data-count="10">0</div><div class="stat-label">a menos de evasão com apoio contínuo*</div></div>
            <div class="reveal"><div class="stat-num" data-count="24">0</div><div class="stat-label">horas de conteúdo publicado por semana</div></div>
            <div class="reveal"><div class="stat-num" data-count="5">0</div><div class="stat-label">a 10% de taxa sobre vendas na plataforma</div></div>
        </div>
    </div>
</section>

<section class="how" id="como-funciona">
    <div class="wrap">
        <div class="how-head reveal">
            <span class="eyebrow">Como funciona</span>
            <h2>Do primeiro acesso à primeira venda.</h2>
        </div>
        <div class="how-grid">
            <div class="how-card reveal"><span class="n">01</span><h4>Cadastro</h4><p>Crie sua conta como cliente ou criadora, informando nome, e-mail e data de nascimento.</p></div>
            <div class="how-card reveal"><span class="n">02</span><h4>Explore</h4><p>Busque projetos e cursos por categoria e conheça o perfil público de cada criadora.</p></div>
            <div class="how-card reveal"><span class="n">03</span><h4>Aprenda e produza</h4><p>Avance em cursos e mentorias, publique projetos com arquivos, preço e descrição.</p></div>
            <div class="how-card reveal"><span class="n">04</span><h4>Conecte e venda</h4><p>Receba avaliações, participe da comunidade e finalize vendas com pagamento integrado.</p></div>
        </div>
    </div>
</section>

<section class="planos" id="planos">
    <div class="wrap">
        <div class="planos-head reveal">
            <span class="eyebrow">Planos</span>
            <h2>Escolha como você quer participar.</h2>
        </div>
        <div class="plans-grid">
            <div class="plan reveal">
                <h3>Estudante</h3>
                <div class="sub">Para começar a aprender</div>
                <ul>
                    <li>Acesso a cursos gratuitos</li>
                    <li>Perfil público básico</li>
                    <li>Participação em grupos e eventos</li>
                </ul>
                <a href="{{ route('cadastro') ?? '#' }}" class="btn btn-ghost btn-block">Criar conta grátis</a>
            </div>
            <div class="plan featured reveal">
                <span class="pill">Mais popular</span>
                <h3>Criadora</h3>
                <div class="sub">Para publicar e vender</div>
                <ul>
                    <li>Tudo do plano Estudante</li>
                    <li>Publicação de projetos e cursos</li>
                    <li>Checkout e pagamento integrado</li>
                </ul>
                <a href="{{ route('cadastro') ?? '#' }}" class="btn btn-primary btn-block">Quero ser criadora</a>
            </div>
            <div class="plan reveal">
                <h3>Empresa parceira</h3>
                <div class="sub">Para apoiar e contratar</div>
                <ul>
                    <li>Mural de vagas e estágios</li>
                    <li>Patrocínio de mentorias</li>
                    <li>Selo de empresa parceira ESG</li>
                </ul>
                <a href="#" class="btn btn-ghost btn-block">Falar com o time</a>
            </div>
        </div>
    </div>
</section>

<section class="cta-final">
    <div class="glow glow-1" style="top:-260px;"></div>
    <div class="wrap">
        <h2 class="reveal">Sua trajetória na tecnologia não precisa continuar sozinha.</h2>
        <p class="reveal">Cadastre-se em minutos e comece a aprender, construir e vender hoje mesmo.</p>
        <a href="{{ route('cadastro') ?? '#' }}" class="btn btn-primary reveal">Criar minha conta</a>
    </div>
</section>

@endsection