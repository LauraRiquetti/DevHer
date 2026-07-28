@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<section class="page-head">
    <div class="wrap">
        <span class="eyebrow">Painel administrativo</span>
        <h1>Visão geral</h1>
        <p>Acompanhe o crescimento da comunidade e modere conteúdos pendentes.</p>
    </div>
</section>

<section style="padding:48px 0 100px;">
    <div class="wrap">

        @if(session('success'))
            <div class="alert alert-success mb-4" style="padding:15px; background-color:#d4edda; color:#155724; border-radius:8px;">
                {{ session('success') }}
            </div>
        @endif

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
            <a href="{{ route('admin.relatorio') }}" class="btn btn-ghost btn-sm">Ver relatório completo</a>
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
                                    <form method="POST" action="{{ route('admin.aprovar', $item['id']) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm">Aprovar</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.remover', $item['id']) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Remover</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" style="color:var(--muted); text-align:center;">Nenhum conteúdo pendente. 🎉</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection