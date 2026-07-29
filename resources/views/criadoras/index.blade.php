@extends('layouts.app')

@section('title', 'Monitoramento de Criadoras')

@section('content')

@php
    // Fallback de exemplo (Mock para não quebrar a tela)
    $criadoras = $criadoras ?? [
        (object)['id' => 1, 'nome' => 'Alice Ferreira', 'email' => 'alice@email.com', 'vendas' => 145, 'status' => 'Ativa'],
        (object)['id' => 2, 'nome' => 'Beatriz Souza', 'email' => 'beatriz@email.com', 'vendas' => 32, 'status' => 'Inativa'],
    ];
@endphp

<section class="page-head">
    <div class="wrap" style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <span class="eyebrow">Administração</span>
            <h1>Monitoramento de Criadoras</h1>
            <p>Gerencie as vendedoras, comissões e status de conta.</p>
        </div>
        <div>
            {{-- Botão caso o admin queira cadastrar uma nova criadora manualmente --}}
            <a href="{{ route('criadoras.create') }}" class="btn btn-primary">Nova Criadora</a>
        </div>
    </div>
</section>

<section style="padding:48px 0 100px;">
    <div class="wrap">
        <div class="card" style="padding: 0; overflow: hidden;">
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead style="background-color: var(--bg-color-light); border-bottom: 1px solid var(--border-color);">
                    <tr>
                        <th style="padding: 16px;">ID</th>
                        <th style="padding: 16px;">Nome</th>
                        <th style="padding: 16px;">E-mail</th>
                        <th style="padding: 16px;">Total de Vendas</th>
                        <th style="padding: 16px;">Status</th>
                        <th style="padding: 16px; text-align: right;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($criadoras as $criadora)
                        <tr style="border-bottom: 1px solid var(--border-color);">
                            <td style="padding: 16px; color: var(--muted);">#{{ $criadora->id }}</td>
                            <td style="padding: 16px; font-weight: 500;">{{ $criadora->nome }}</td>
                            <td style="padding: 16px;">{{ $criadora->email }}</td>
                            <td style="padding: 16px;">{{ $criadora->vendas }}</td>
                            <td style="padding: 16px;">
                                <span style="padding: 4px 8px; border-radius: 4px; font-size: 12px; background-color: {{ $criadora->status == 'Ativa' ? '#dcfce7' : '#fee2e2' }}; color: {{ $criadora->status == 'Ativa' ? '#166534' : '#991b1b' }};">
                                    {{ $criadora->status }}
                                </span>
                            </td>
                            <td style="padding: 16px; text-align: right;">
                                <a href="{{ route('criadoras.edit', $criadora->id) }}" class="btn btn-sm btn-ghost" style="font-size: 14px;">Editar</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="padding: 32px; text-align: center; color: var(--muted);">
                                Nenhuma criadora encontrada.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Aqui entraria a paginação: {{ $criadoras->links() }} --}}
    </div>
</section>
@endsection