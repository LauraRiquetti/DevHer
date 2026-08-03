@extends('Layouts.app')

@section('title', 'Dashboard')

@section('content')

@php
    $kpis = $kpis ?? [
        ['label' => 'Usuárias ativas', 'valor' => '1.284', 'delta' => '+8,2%', 'up' => true],
        ['label' => 'Projetos publicados', 'valor' => '312', 'delta' => '+4,1%', 'up' => true],
        ['label' => 'Cursos publicados', 'valor' => '96', 'delta' => '+1,5%', 'up' => true],
        ['label' => 'Vendas no mês', 'valor' => 'R$ 18.430', 'delta' => '-2,3%', 'up' => false],
    ];
    $pendencias = $pendencias ?? [
        ['tipo' => 'Projeto', 'titulo' => 'Bot de análise de dados', 'autora' => 'Bianca Silva'],
        ['tipo' => 'Curso', 'titulo' => 'Introdução a redes', 'autora' => 'Juliana Prado'],
        ['tipo' => 'Comentário', 'titulo' => 'Denúncia de conteúdo', 'autora' => 'Anônimo'],
    ];
@endphp

<section class="page-head">
    <div class="wrap">
        <span class="eyebrow">Painel administrativo</span>
        <h1>Visão geral</h1>
        <p>Acompanhe o crescimento da comunidade e modere conteúdos pendentes.</p>
    </div>
</section>

<section style="padding:48px 0 100px;">
    <div class="wrap">

        <div class="kpi-grid">
            @foreach ($kpis as $kpi)
                <div class="kpi-card">
                    <div class="kpi-label">{{ $kpi['label'] }}</div>
                    <div class="kpi-value">{{ $kpi['valor'] }}</div>
                    <div class="kpi-delta {{ $kpi['up'] ? '' : 'down' }}">{{ $kpi['delta'] }} este mês</div>
                </div>
            @endforeach
        </div>

        <div class="panel-title">
            <h3>Conteúdos aguardando aprovação</h3>
            <a href="{{ route('admin.relatorio') ?? '#' }}" class="btn btn-ghost btn-sm">Ver relatório completo</a>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>Título</th>
                        <th>Autora</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pendencias as $item)
                        <tr>
                            <td>{{ $item['tipo'] }}</td>
                            <td>{{ $item['titulo'] }}</td>
                            <td>{{ $item['autora'] }}</td>
                            <td>
                                <div class="table-actions">
                                    <form method="POST" action="{{ route('admin.aprovar', $item['id'] ?? 1) ?? '#' }}">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm">Aprovar</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.remover', $item['id'] ?? 1) ?? '#' }}"
                                          data-confirm="Remover este conteúdo?">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Remover</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" style="color:var(--muted);">Nenhum conteúdo pendente. 🎉</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection