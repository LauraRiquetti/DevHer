@extends('Layouts.app')

@section('title', 'Usuários')

@section('content')

@php
    $usuarios = $usuarios ?? [
        ['nome' => 'Mariana Costa', 'email' => 'mariana@email.com', 'tipo' => 'Criadora', 'status' => 'ativo'],
        ['nome' => 'Fernanda Alves', 'email' => 'fernanda@email.com', 'tipo' => 'Cliente', 'status' => 'ativo'],
        ['nome' => 'Juliana Prado', 'email' => 'juliana@email.com', 'tipo' => 'Criadora', 'status' => 'pendente'],
        ['nome' => 'Renata Souza', 'email' => 'renata@email.com', 'tipo' => 'Cliente', 'status' => 'bloqueado'],
    ];
@endphp

<section class="page-head">
    <div class="wrap">
        <span class="eyebrow">Painel administrativo</span>
        <h1>Gerenciar usuários</h1>
        <p>Aprove cadastros, altere permissões e remova acessos quando necessário.</p>
    </div>
</section>

<section style="padding:48px 0 100px;">
    <div class="wrap">
        <div class="table-toolbar">
            <input type="text" placeholder="Buscar por nome ou e-mail...">
            <a href="{{ route('usuarios.create') ?? '#' }}" class="btn btn-primary btn-sm">+ Novo usuário</a>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Tipo de perfil</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario['nome'] }}</td>
                            <td>{{ $usuario['email'] }}</td>
                            <td>{{ $usuario['tipo'] }}</td>
                            <td>
                                <span class="status-pill status-{{ $usuario['status'] }}">
                                    {{ ucfirst($usuario['status']) }}
                                </span>
                            </td>
                            <td>
                                <div class="table-actions">
                                    <a href="{{ route('usuarios.edit', $usuario['id'] ?? 1) ?? '#' }}" class="btn btn-ghost btn-sm">Editar</a>
                                    <form method="POST" action="{{ route('usuarios.destroy', $usuario['id'] ?? 1) ?? '#' }}"
                                          data-confirm="Tem certeza que deseja remover este usuário?">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Remover</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" style="color:var(--muted);">Nenhum usuário encontrado.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection