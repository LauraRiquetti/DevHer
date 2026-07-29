{{-- Estende o layout principal da aplicação --}}
@extends('layouts.app')

{{-- Nome do título da página --}}
@section('title', 'Usuários')

@section('content')

<section class="page-head">
    <div class="wrap">
        <span class="eyebrow">Painel administrativo</span>
        <h1>Gerenciar usuários</h1>
        <p>Aprove cadastros, altere permissões e remova acessos quando necessário.</p>
    </div>
</section>

<section style="padding:48px 0 100px;">
    <div class="wrap">
        
        <!-- Toolbar com o formulário de busca REAL -->
        <div class="table-toolbar" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            
            {{-- Formulário de pesquisa disparando um GET para a própria página --}}
            <form action="{{ route('usuarios.index') }}" method="GET" style="display: flex; gap: 8px; width: 100%; max-width: 400px;">
                <!-- O request('search') mantém o termo pesquisado na barra após recarregar -->
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por nome ou e-mail..." style="width: 100%;">
                <button type="submit" class="btn btn-primary btn-sm">Pesquisar</button>
                
                {{-- Botão de limpar busca (só aparece se houver algo pesquisado) --}}
                @if(request('search'))
                    <a href="{{ route('usuarios.index') }}" class="btn btn-ghost btn-sm">Limpar</a>
                @endif
            </form>

            {{-- O botão de "Novo usuário" foi removido daqui conforme nossa nova regra de negócio! --}}
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
                    {{-- O $usuarios agora vem direto do Controller (banco de dados) --}}
                    @forelse ($usuarios as $usuario)
                        <tr>
                            {{-- Usando a sintaxe de objeto (->) pois agora é um Model do Eloquent --}}
                            <td>{{ $usuario->name }}</td>
                            <td>{{ $usuario->email }}</td>
                            <td>{{ ucfirst($usuario->tipo_perfil) }}</td>
                            <td>
                                <span class="status-pill status-{{ $usuario->status }}">
                                    {{ ucfirst($usuario->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="table-actions">
                                    <a href="{{ route('usuarios.edit', $usuario->id) }}" class="btn btn-ghost btn-sm">Editar</a>
                                    
                                    {{-- Formulário de exclusão real --}}
                                    <form method="POST" action="{{ route('usuarios.destroy', $usuario->id) }}" 
                                          onsubmit="return confirm('Tem certeza que deseja remover este usuário?');" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Remover</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            {{-- Mensagem amigável caso a busca não retorne nada ou o banco esteja vazio --}}
                            <td colspan="5" style="color:var(--muted); text-align:center; padding: 24px;">
                                Nenhum usuário encontrado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Exibe a paginação (ex: botões de Próxima Página / Página Anterior) --}}
        <div style="margin-top: 24px; display: flex; justify-content: center;">
            {{ $usuarios->withQueryString()->links() }}
        </div>

    </div>
</section>
@endsection