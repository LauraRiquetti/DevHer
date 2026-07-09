@extends('layouts.app')

@section('title', 'Relatório')

@section('content')

@php
    $linhas = $linhas ?? [
        ['mes' => 'Fevereiro', 'novas_usuarias' => 210, 'projetos_vendidos' => 48, 'receita' => 'R$ 4.120,00'],
        ['mes' => 'Março', 'novas_usuarias' => 264, 'projetos_vendidos' => 61, 'receita' => 'R$ 5.870,00'],
        ['mes' => 'Abril', 'novas_usuarias' => 301, 'projetos_vendidos' => 77, 'receita' => 'R$ 7.240,00'],
    ];
@endphp

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
                    @foreach ($linhas as $linha)
                        <tr>
                            <td>{{ $linha['mes'] }}</td>
                            <td>{{ $linha['novas_usuarias'] }}</td>
                            <td>{{ $linha['projetos_vendidos'] }}</td>
                            <td>{{ $linha['receita'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="margin-top:24px;">
            <a href="{{ route('admin.dashboard') ?? '#' }}" class="btn btn-ghost">Voltar ao dashboard</a>
        </div>
    </div>
</section>
@endsection