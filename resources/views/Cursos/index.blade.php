@extends('layouts.app')

@section('title', 'Cursos')

@section('content')

<section class="page-head">
    <div class="glow glow-1" style="top:-260px;"></div>
    <div class="wrap">
        <span class="eyebrow">Aprender</span>
        <h1>Cursos e mentorias</h1>
        <p>Conteúdos publicados por criadoras da comunidade, do primeiro código à especialização.</p>
    </div>
</section>

<section style="padding:48px 0 100px;">
    <div class="wrap">

        {{-- Mensagem de Sucesso --}}
        @if (session('sucesso'))
            <div style="padding: 12px 16px; background: #d4edda; color: #155724; border-radius: 6px; margin-bottom: 24px;">
                {{ session('sucesso') }}
            </div>
        @endif

        {{-- Toolbar de Filtro e Busca --}}
        <form method="GET" action="{{ route('cursos.index') }}" class="table-toolbar">
            <input type="text" name="busca" placeholder="Buscar curso..." value="{{ request('busca') }}">

            <div style="display:flex; gap:10px; flex-wrap:wrap;">
                <label class="chip" style="cursor:pointer;">
                    <input type="radio" name="filtro" value="" style="display:none;"
                           {{ !request('filtro') ? 'checked' : '' }} onchange="this.form.submit()">
                    Todos
                </label>
                <label class="chip" style="cursor:pointer;">
                    <input type="radio" name="filtro" value="gratuito" style="display:none;"
                           {{ request('filtro') === 'gratuito' ? 'checked' : '' }} onchange="this.form.submit()">
                    Gratuitos
                </label>
                <label class="chip" style="cursor:pointer;">
                    <input type="radio" name="filtro" value="pago" style="display:none;"
                           {{ request('filtro') === 'pago' ? 'checked' : '' }} onchange="this.form.submit()">
                    Pagos
                </label>
            </div>

            @auth
                <a href="{{ route('cursos.create') }}" class="btn btn-primary btn-sm">+ Publicar curso</a>
            @endauth
        </form>

        {{-- Grid de Cursos (mesma estrutura visual do Marketplace) --}}
        <div class="proj-grid" style="margin-top:32px;">
            @forelse ($cursos as $curso)
                @php
                    $isRestrito = isset($curso->is_18plus) ? $curso->is_18plus : ($curso->categoria === '18+');
                    $bloqueado = $isRestrito && ($idadeUsuaria === null || $idadeUsuaria < 18);
                @endphp

                <div class="proj-card" style="{{ $bloqueado ? 'opacity:.55;' : '' }}">
                    {{-- Miniatura + título clicáveis, levando para a página de detalhes do curso --}}
                    <a href="{{ route('cursos.show', $curso->id) }}" style="display:block; text-decoration:none; color:inherit;">
                        <div class="proj-thumb">
                            @if($curso->imagem)
                                <img src="{{ $curso->imagem }}" alt="{{ $curso->nome }}" style="width:100%; height:100%; object-fit:cover;">
                            @endif
                        </div>

                        @if($curso->categoria)
                            <span class="categoria" style="text-transform: capitalize;">{{ $curso->categoria }}</span>
                        @endif

                        <h4>{{ $curso->nome }}</h4>
                    </a>
                    <span class="autora">por {{ $curso->user->name ?? 'Autora desconhecida' }}</span>

                    <span class="price">
                        @if(($curso->preco ?? 0) == 0)
                            Gratuito
                        @else
                            R$ {{ number_format($curso->preco, 2, ',', '.') }}
                        @endif
                    </span>

                    <div style="margin-top:10px;">
                        @if ($isRestrito)
                            <span class="badge-18">18+</span>
                        @else
                            <span class="badge-free">Livre</span>
                        @endif
                    </div>

                    @if ($bloqueado)
                        <p style="font-size:12px;color:var(--muted-2);margin-top:10px;">
                            Este curso é liberado apenas para usuárias com 18 anos ou mais.
                        </p>
                        <button class="btn btn-ghost btn-sm btn-block" disabled style="opacity:0.6; cursor:not-allowed; margin-top:12px;">
                            Indisponível
                        </button>
                    @else
                        {{-- Mesmo padrão de rota usado no marketplace, trocando 'tipo' para 'curso' --}}
                        <form method="POST" action="{{ route('carrinho.add', ['tipo' => 'curso', 'id' => $curso->id]) }}" style="margin-top:12px;">
                            @csrf
                            <button type="submit" class="btn btn-ghost btn-sm btn-block">Adicionar ao carrinho</button>
                        </form>
                    @endif
                </div>
            @empty
                <p style="color:var(--muted);">Nenhum curso encontrado para este filtro.</p>
            @endforelse
        </div>

        {{-- Paginação --}}
        @if (method_exists($cursos, 'links'))
            {{-- A view padrão do Laravel usa classes do Tailwind (ex: sm:hidden) que não existem no
                 CSS deste projeto. Sem Tailwind, os dois blocos de navegação (mobile e desktop) ficam
                 visíveis ao mesmo tempo, exibindo texto solto como "« Previous" / "Next »".
                 O bloco abaixo corrige isso via CSS, sem precisar de uma view de paginação separada. --}}
            <div class="cursos-pagination" style="margin-top:32px;">
                {{ $cursos->links() }}
            </div>

            <style>
                /* Esconde a versão simplificada (mobile) da paginação padrão do Laravel,
                   que só existia por causa da classe Tailwind "sm:hidden" (inerte sem Tailwind) */
                .cursos-pagination nav[role="navigation"] > div[class*="sm:hidden"] {
                    display: none !important;
                }

                /* Exibe sempre a versão completa (com números de página), que ficava
                   escondida pela classe Tailwind "hidden" (também inerte sem Tailwind) */
                .cursos-pagination nav[role="navigation"] > div.hidden {
                    display: flex !important;
                    align-items: center;
                    justify-content: space-between;
                    flex-wrap: wrap;
                    gap: 16px;
                }

                .cursos-pagination nav[role="navigation"] span.relative {
                    display: inline-flex;
                    align-items: center;
                    gap: 4px;
                    flex-wrap: wrap;
                }

                /* Texto "Showing X to Y of Z results" */
                .cursos-pagination nav[role="navigation"] p {
                    margin: 0;
                    font-size: 0.85rem;
                    color: var(--muted, #6b7280);
                }

                /* Botões de página (números e setas anterior/próxima) */
                .cursos-pagination nav[role="navigation"] a,
                .cursos-pagination nav[role="navigation"] span[aria-current] span {
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    min-width: 38px;
                    height: 38px;
                    padding: 0 10px;
                    border-radius: 8px;
                    border: 1px solid rgba(255, 45, 135, 0.25);
                    background: #fff;
                    color: #1c1c1c;
                    font-size: 0.85rem;
                    font-weight: 600;
                    text-decoration: none;
                    transition: all .2s ease;
                }

                .cursos-pagination nav[role="navigation"] a:hover {
                    border-color: #FF2D87;
                    color: #FF2D87;
                    background: rgba(255, 45, 135, 0.06);
                }

                /* Página atual, destacada em rosa */
                .cursos-pagination nav[role="navigation"] span[aria-current] span {
                    background: #FF2D87;
                    border-color: #FF2D87;
                    color: #fff;
                    cursor: default;
                }

                .cursos-pagination nav[role="navigation"] svg {
                    width: 16px;
                    height: 16px;
                }
            </style>
        @endif

    </div>
</section>
@endsection