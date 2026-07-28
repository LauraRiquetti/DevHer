@extends('layouts.app')

@section('title', 'Relatório')

@section('content')

<section class="page-head">
    <div class="wrap">
        <span class="eyebrow">Painel administrativo</span>
        <h1>Relatório de crescimento</h1>
        <p>Evolução mensal de usuárias, vendas e receita da plataforma.</p>
    </div>
</section>

<section style="padding:48px 0 100px;">
    <div class="wrap">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Mês</th>
                        <th>Novas usuárias</th>
                        <th>Projetos vendidos</th>
                        <th>Receita</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($linhas as $linha)
                        <tr>
                            <td>{{ $linha['mes'] }}</td>
                            <td>{{ $linha['novas_usuarias'] }}</td>
                            <td>{{ $linha['projetos_vendidos'] }}</td>
                            <td>{{ $linha['receita'] }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" style="text-align:center;">Nenhum registro encontrado.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:24px;">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-ghost">Voltar ao dashboard</a>
        </div>
    </div>
</section>
@endsections