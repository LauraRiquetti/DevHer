@extends('Layouts.app')

@section('title', 'Compra confirmada')

@section('content')

@php
    $pedido = $pedido ?? ['numero' => '#DH-10432', 'total' => '154,00'];
@endphp

<section class="hero" style="padding:120px 0;">
    <div class="glow glow-1"></div>
    <div class="wrap" style="text-align:center;position:relative;z-index:1;max-width:520px;">
        <span class="eyebrow">Pedido confirmado</span>
        <h1 style="margin:20px 0 14px;">Sua compra foi realizada! 🎉</h1>
        <p style="color:var(--muted);margin-bottom:8px;">
            Pedido {{ $pedido['numero'] }} — total de R$ {{ $pedido['total'] }}.
        </p>
        <p style="color:var(--muted);margin-bottom:36px;">
            Os arquivos já estão disponíveis na sua área "Meus pedidos".
        </p>
        <div style="display:flex;gap:14px;justify-content:center;flex-wrap:wrap;">
            <a href="{{ route('meus-pedidos') ?? '#' }}" class="btn btn-primary">Ver meus pedidos</a>
            <a href="{{ route('projetos.index') ?? '#' }}" class="btn btn-ghost">Continuar explorando</a>
        </div>
    </div>
</section>
@endsection