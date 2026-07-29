@extends('layouts.app')

@php
    $usuario = Auth::user();
@endphp

@section('title', 'Perfil de ' . $usuario->name)

@section('content')
<section class="page-head">
    <div class="wrap">
        <div class="profile-head reveal in" style="display: flex; align-items: center; gap: 16px;">
            {{-- Avatar dinâmico com a inicial do nome --}}
            <div class="avatar" style="width: 64px; height: 64px; background-color: var(--pink-light, #e83e8c); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 24px;">
                {{ strtoupper(substr($usuario->name, 0, 1)) }}
            </div>
            <div>
                <h4 style="font-size:22px; margin: 0;">{{ $usuario->name }}</h4>
                <span style="color: var(--muted); font-size: 14px;">
                    Cliente desde {{ $usuario->created_at ? $usuario->created_at->format('Y') : date('Y') }}
                </span>
            </div>
        </div>
    </div>
</section>

<section style="padding:48px 0 100px;">
    <div class="wrap" style="display:grid; grid-template-columns:1.4fr 1fr; gap:40px;">

        <!-- Coluna de Dados -->
        <div>
            <div class="panel-title"><h3>Meus Dados</h3></div>
            <div class="card" style="line-height: 1.8;">
                <p><strong>E-mail:</strong> {{ $usuario->email }}</p>
                <p><strong>Telefone:</strong> {{ $usuario->telefone ?? 'Não informado' }}</p>
                <p>
                    <strong>Localização:</strong> 
                    @if(!empty($usuario->cidade) || !empty($usuario->estado))
                        {{ $usuario->cidade ?? '' }} {{ isset($usuario->cidade, $usuario->estado) ? '/' : '' }} {{ $usuario->estado ?? '' }}
                    @else
                        Não informada
                    @endif
                </p>
            </div>
            
            <div class="panel-title" style="margin-top: 32px;"><h3>Minhas Compras</h3></div>
            <div class="card">
                <p style="color:var(--muted); font-size: 14px;">Você ainda não possui compras registradas.</p>
            </div>
        </div>

        <!-- Coluna de Ações -->
        <div>
            <div class="panel-title"><h3>Configurações de Conta</h3></div>
            <div class="card">
                <p style="font-size: 14px; color: var(--muted); margin-bottom: 16px;">
                    Mantenha seus dados sempre atualizados para evitar problemas em seus pedidos.
                </p>
                <a href="{{ route('clientes.edit', $usuario->id) }}" class="btn btn-primary btn-sm" style="display: block; text-align: center;">
                    Editar Perfil
                </a>
            </div>
        </div>

    </div>
</section>
@endsection