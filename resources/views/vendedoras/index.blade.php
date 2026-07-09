@extends('Layouts.app')

@section('title', 'Vendedoras')

@section('content')

<section class="page-head">
    <div class="wrap">
        <span class="eyebrow">Comunidade</span>
        <h1>Vendedoras cadastradas</h1>
        <p>Lista de criadoras cadastradas na plataforma.</p>
    </div>
</section>

<section style="padding:48px 0 100px;">
    <div class="wrap">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Cidade</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($vendedoras ?? [] as $vendedora)
                        <tr>
                            <td>{{ $vendedora->nome }}</td>
                            <td>{{ $vendedora->email }}</td>
                            <td>{{ $vendedora->cidade }}</td>
                            <td>{{ $vendedora->estado }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" style="color:var(--muted);">Nenhuma vendedora cadastrada ainda.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection