<!-- Extende a estrutura base definida no layout principal da aplicação -->
@extends('layouts.app')

<!-- Define o título da aba do navegador para a página inicial -->
@section('title', 'Início')

<!-- Início do bloco de conteúdo principal inserido no @yield('content') do layout -->
@section('content')

<!-- Seção principal da página (Hero Banner) -->
<section class="hero hero-with-photo">
    <div class="hero-top">
        {{-- Foto de fundo (mulher programando) com degradê rosa por cima, texto à esquerda --}}
        <div class="hero-photo-layer">
            <img src="{{ asset('images/hero-mulher-programando.jpg') }}" alt="Mulher programando" class="hero-photo-img">
            <div class="hero-photo-gradient"></div>
        </div>

        <!-- Elementos visuais de iluminação/brilho estilizados via CSS -->
        <div class="glow glow-1"></div>
        <div class="glow glow-2"></div>
        <div class="wrap hero-inner hero-inner-left">
            <!-- Subtítulo de apresentação do projeto -->
            <span class="eyebrow">Feito por, com e para mulheres da tecnologia</span>
            <!-- Título principal da landing page -->
            <h1 class="hero-hover">Aprenda, conecte-se e <span class="accent">venda seus projetos</span> em tecnologia.</h1>
            <!-- Descrição geral da proposta da plataforma -->
            <p>Cursos, mentorias, portfólio e uma comunidade real de mulheres na TI — em um único ecossistema pensado para reduzir a evasão feminina e abrir portas no mercado.</p>
            <!-- Botões de chamada para ação (CTAs) -->
            <div class="hero-ctas">
                <!-- Verifica se o usuário está autenticado na sessão -->
                @auth
                    {{-- Exibe O BOTÃO SOMENTE se for Admin --}}
                    @if(auth()->user()->role === 'admin' || auth()->user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Acessar Painel Admin</a>
                    @endif
                @else
                    <!-- Caso seja um visitante não logado, exibe a opção de cadastro -->
                    <a href="{{ route('cadastro') }}" class="btn btn-primary">Comece grátis</a>
                @endauth
                <!-- Âncora para rolar a página até a seção informativa -->
                <a href="#como-funciona" class="btn btn-ghost">Ver como funciona</a>
            </div>
        </div>
    </div>

    {{-- Estilo do banner com foto de fundo + degradê rosa --}}
    <style>
        .hero-top {
            position: relative;
            overflow: hidden;
            min-height: 640px;
            display: flex;
            align-items: center;
            justify-content: flex-start;
        }
        .hero-photo-layer {
            position: absolute;
            inset: 0;
            z-index: 0;
        }
        .hero-photo-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center 22%;
            display: block;
        }
        /* Degradê: preto sólido atrás do texto (esquerda), dissolvendo em rosa
           até revelar a foto sem filtro do lado direito da tela */
        .hero-photo-gradient {
            position: absolute;
            inset: 0;
            background:
                /* Camada 1: vira preto sólido logo na metade da altura, sem deixar resíduo visível da foto embaixo */
                linear-gradient(
                    180deg,
                    transparent 0%,
                    transparent 45%,
                    #050507 68%
                ),
                /* Camada 2: degradê da esquerda (preto sólido) pra direita (foto revelada) */
                linear-gradient(
                    90deg,
                    #050507 0%,
                    #050507 16%,
                    rgba(5, 5, 7, 0.94) 30%,
                    rgba(255, 45, 135, 0.55) 45%,
                    rgba(255, 45, 135, 0.22) 62%,
                    rgba(255, 45, 135, 0.05) 78%,
                    transparent 92%
                );
        }
        .hero-top .hero-inner {
            position: relative;
            z-index: 1;
        }
        .hero-top .glow {
            z-index: 1;
        }
        .hero-inner-left {
            position: relative !important;
            left: auto !important;
            right: auto !important;
            top: auto !important;
            transform: none !important;
            text-align: left;
            max-width: 620px;
            width: 100%;
            margin: 0 !important;
        }
        .hero-inner-left .hero-ctas {
            justify-content: flex-start;
        }
        /* Em telas menores a foto vira um pano de fundo geral, com degradê de cima pra baixo */
        @media (max-width: 900px) {
            .hero-photo-gradient {
                background: linear-gradient(
                    180deg,
                    #050507 0%,
                    #050507 50%,
                    rgba(5, 5, 7, 0.88) 68%,
                    rgba(255, 45, 135, 0.4) 82%,
                    #050507 100%
                );
            }
            .hero-inner-left {
                max-width: 100%;
                text-align: center;
            }
            .hero-inner-left .hero-ctas {
                justify-content: center;
            }
        }
    </style>

   

    {{-- Efeito simples: o título principal fica colorido ao passar o mouse --}}
    <style>
        .hero-hover {
            transition: color .25s ease;
        }
        .hero-hover:hover {
            color: #FF2D87;
        }
        /* O trecho em destaque (accent) muda para um tom levemente mais claro no hover, mantendo contraste */
        .hero-hover:hover .accent {
            color: #FF9AC7;
        }
    </style>
</section>

<!-- Seção do passo a passo do fluxo da aplicação -->
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

<!-- Seção de apoio / comunidades parceiras -->
<section class="apoio apoio-grande">
    <div class="wrap apoio-inner">
        {{-- Persona ao lado esquerdo, igual ao navbar --}}
        <div class="apoio-persona">
            <img src="{{ asset('images/persona-devher.png') }}" alt="Persona DevHer" class="apoio-persona-img">
        </div>
        <div class="apoio-content">
            <p>Redes e iniciativas que caminham com a gente</p>
            <!-- Chips/tags com nomes das comunidades representadas -->
            <div class="apoio-row">
                <a href="{{ route('comunidades.show', 'pyladies') }}" class="chip" style="text-decoration:none; cursor:pointer;">PyLadies</a>
                <a href="{{ route('comunidades.show', 'women-techmakers') }}" class="chip" style="text-decoration:none; cursor:pointer;">Women Techmakers</a>
                <a href="{{ route('comunidades.show', 'meninas-digitais') }}" class="chip" style="text-decoration:none; cursor:pointer;">Meninas Digitais</a>
                <a href="{{ route('comunidades.show', 'programadas') }}" class="chip" style="text-decoration:none; cursor:pointer;">ProgramAdas</a>
                <a href="{{ route('comunidades.show', 'rails-girls') }}" class="chip" style="text-decoration:none; cursor:pointer;">Rails Girls</a>
                <a href="{{ route('comunidades.show', 'marias-da-tech') }}" class="chip" style="text-decoration:none; cursor:pointer;">Marias da Tech</a>
            </div>
        </div>
    </div>

    {{-- Estilo: seção maior + persona à esquerda --}}
    <style>
        .apoio-grande {
            padding: 72px 0;
        }
        .apoio-inner {
            display: flex !important;
            align-items: center;
            justify-content: flex-start !important;
            gap: 40px;
            flex-wrap: wrap;
            text-align: left !important;
        }
        .apoio-persona {
            flex: 0 0 auto;
        }
        .apoio-persona-img {
            width: 260px;
            height: 260px;
            border-radius: 20px;
            object-fit: cover;
            display: block;
            box-shadow: 0 12px 32px rgba(255, 45, 135, 0.25);
        }
        .apoio-content {
            flex: 1 1 380px;
            text-align: left;
        }
        .apoio-content p {
            text-align: left;
            font-size: 1.2rem;
            margin-bottom: 22px;
        }
        .apoio-content .apoio-row {
            justify-content: flex-start;
        }
        .apoio-content .chip {
            font-size: 1rem;
            padding: 12px 22px;
        }
        /* Em telas menores, empilha e centraliza pra não espremer */
        @media (max-width: 720px) {
            .apoio-inner {
                justify-content: center !important;
                text-align: center !important;
            }
            .apoio-content {
                text-align: center;
            }
            .apoio-content p {
                text-align: center;
            }
            .apoio-content .apoio-row {
                justify-content: center;
            }
            .apoio-persona-img {
                width: 200px;
                height: 200px;
            }
        }
    </style>
</section>


{{-- Seção de Marketplace --}}
<section class="feature" id="marketplace">
    <div class="wrap">
        <!-- Texto explicativo da funcionalidade de Marketplace -->
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
        <!-- Mockup visual simulando a interface da loja -->
        <div class="mock reveal">
            <div class="mock-bar"><span></span><span></span><span></span></div>
            <div class="mock-title">marketplace / projetos em alta</div>
            <div class="proj-grid">
                <!-- Itera pelos 2 primeiros projetos passados pelo controller -->
                @forelse($projetos->take(2) as $projeto)
                    <div class="proj-card">
                        <div class="proj-thumb"></div>
                        <!-- Exibe título/nome do projeto -->
                        <h4>{{ $projeto->titulo ?? $projeto->nome }}</h4>
                        <!-- Formata o valor numérico para a moeda brasileira (R$) -->
                        <span class="price">
                            R$ {{ number_format($projeto->preco ?? $projeto->valor ?? 0, 2, ',', '.') }}
                        </span>
                    </div>
                @empty
                    <!-- Exibição padrão caso o banco não retorne nenhum projeto -->
                    <div class="proj-card">
                        <div class="proj-thumb"></div>
                        <h4>Nenhum projeto cadastrado</h4>
                        <span class="price">R$ 0,00</span>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</section>

{{-- Seção de Cursos e Mentorias --}}
<section class="feature reverse" id="cursos">
    <div class="wrap">
        <!-- Texto explicativo da área de cursos -->
        <div class="feature-copy reveal">
            <span class="eyebrow">Cursos e mentorias</span>
            <h2>Aprenda no seu ritmo, com quem já passou pelo caminho.</h2>
            <p>Video-aulas, workshops e mentorias publicadas por criadoras da própria comunidade.</p>
            <div class="feature-tags">
                <span class="tag">VÍDEO-AULAS</span>
                <span class="tag">MENTORIAS AO VIVO</span>
            </div>
        </div>
        <!-- Mockup de listagem dos cursos cadastrados -->
        <div class="mock reveal">
            <div class="mock-bar"><span></span><span></span><span></span></div>
            <div class="mock-title">cursos / recomendados para você</div>
            
            <!-- Itera pelos 3 primeiros cursos retornados da consulta -->
            @forelse($cursos->take(3) as $key => $curso)
                <div class="course-row">
                    <!-- Contador visual ordenado no formato (01, 02, 03) -->
                    <div class="course-thumb">0{{ $key + 1 }}</div>
                    <div>
                        <!-- Exibe o título do curso -->
                        <h4>{{ $curso->titulo ?? $curso->nome }}</h4>
                        <span>
                            <!-- Formata a exibição do preço ou exibe 'Gratuito' se for valor zero -->
                            @if(($curso->preco ?? 0) == 0)
                                Gratuito
                            @else
                                R$ {{ number_format($curso->preco, 2, ',', '.') }}
                            @endif
                            · {{ $curso->duracao ?? 'Carga horária N/A' }}
                        </span>
                    </div>
                    <!-- Exibe selo para conteúdos voltados a maiores de 18 anos, se configurado -->
                    @if(isset($curso->is_18plus) && $curso->is_18plus)
                        <span class="badge-18">18+</span>
                    @endif
                </div>
            @empty
                <!-- Mensagem padrão exibida na ausência de registros -->
                <p style="color: var(--muted); padding: 16px;">Nenhum curso cadastrado no momento.</p>
            @endforelse

        </div>
    </div>
</section>

{{-- Seção de Estatísticas do Ecossistema --}}
<section class="stats">
    <div class="wrap">
        <h2 class="reveal">Cada número representa uma trajetória que continuou.</h2>
        <div class="stats-grid">
            <!-- Total de criadoras cadastradas -->
            <div class="reveal">
                <div class="stat-num" data-count="{{ $totalCriadoras > 0 ? $totalCriadoras : 18 }}">{{ $totalCriadoras }}</div>
                <div class="stat-label">criadoras cadastradas na plataforma</div>
            </div>
            <!-- Total de projetos publicados no marketplace -->
            <div class="reveal">
                <div class="stat-num" data-count="{{ $totalProjetos > 0 ? $totalProjetos : 10 }}">{{ $totalProjetos }}</div>
                <div class="stat-label">projetos ativos no marketplace</div>
            </div>
            <!-- Indicador estático de disponibilidade de conteúdo -->
            <div class="reveal">
                <div class="stat-static" style="font-size: var(--stat-size, 3rem); font-weight: 800; color: var(--pink-main, #ff2d87);">24h</div>
                <div class="stat-label">de conteúdo disponível</div>
            </div>
            <!-- Indicador estático de porcentagem da taxa da plataforma -->
            <div class="reveal">
                <div class="stat-num" data-count="5">5</div>
                <div class="stat-label">de taxa sobre vendas no ecossistema</div>
            </div>
        </div>
    </div>
</section>

<!-- Seção de pilares/jornada do ecossistema -->
<section class="planos" id="jornada">
    <div class="wrap">
        <div class="planos-head reveal">
            <span class="eyebrow">Comece agora</span>
            <h2>Sua jornada como desenvolvedora começa aqui.</h2>
            <p style="color: var(--muted); max-width: 600px; margin: 12px auto 0; font-size: 1.1rem; line-height: 1.6;">
                Tudo o que você precisa para aprender, construir um portfólio de impacto e rentabilizar seus projetos em uma comunidade feita por e para mulheres na TI.
            </p>
        </div>
        
        <div class="plans-grid" style="grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px;">
            <!-- Pilar 1: Aprender -->
            <div class="plan reveal">
                <h3>01. Aprenda</h3>
                <div class="sub">Desenvolva novas habilidades</div>
                <p style="color: var(--muted); font-size: 0.95rem; margin-bottom: 20px;">
                    Acesse cursos, workshops e mentorias práticas ministradas por outras mulheres da área da tecnologia.
                </p>
                <a href="{{ route('cursos.index') }}" class="btn btn-ghost btn-block">Explorar cursos</a>
            </div>

            <!-- Pilar 2: Conectar (Com destaque visual) -->
            <div class="plan featured reveal">
                <span class="pill">Comunidade</span>
                <h3>02. Conecte-se</h3>
                <div class="sub">Faça parte do ecossistema</div>
                <p style="color: var(--muted); font-size: 0.95rem; margin-bottom: 20px;">
                    Troque experiências, encontre parcerias para projetos e fortaleça sua rede de contatos na área de TI.
                </p>
                <!-- Verificação de perfil para direcionamento correto dos botões -->
                @auth
                    @if(auth()->user()->role === 'admin' || auth()->user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary btn-block">Acessar Painel Admin</a>
                    @endif
                @else
                    <a href="{{ route('cadastro') }}" class="btn btn-primary btn-block">Criar minha conta</a>
                @endauth
            </div>

            <!-- Pilar 3: Rentabilizar -->
            <div class="plan reveal">
                <h3>03. Rentabilize</h3>
                <div class="sub">Venda seus projetos</div>
                <p style="color: var(--muted); font-size: 0.95rem; margin-bottom: 20px;">
                    Publique seus scripts, sistemas e componentes no marketplace e transforme seu conhecimento em renda real.
                </p>
                <a href="{{ route('projetos.index') }}" class="btn btn-ghost btn-block">Ver marketplace</a>
            </div>
        </div>
    </div>
</section>

<!-- Seção de chamada para ação final no rodapé da página -->
<section class="cta-final">
    <div class="glow glow-1" style="top:-260px;"></div>
    <div class="wrap">
        <h2 class="reveal">Sua trajetória na tecnologia não precisa continuar sozinha.</h2>
        <p class="reveal">Cadastre-se em minutos e comece a aprender, construir e vender hoje mesmo.</p>
        <!-- Redirecionamento condicional de acordo com o status de autenticação -->
        @auth
            @if(auth()->user()->role === 'admin' || auth()->user()->is_admin)
                <a href="{{ route('admin.dashboard') }}" class="btn btn-primary reveal">Acessar Painel Admin</a>
            @endif
        @else
            <a href="{{ route('cadastro') }}" class="btn btn-primary reveal">Criar minha conta</a>
        @endauth
    </div>
</section>

@endsection