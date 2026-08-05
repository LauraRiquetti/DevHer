<?php

namespace App\Http\Controllers;

// Importação da Model Projeto e da classe Request
use App\Models\Projeto;
use Illuminate\Http\Request;

class ProjetoController extends Controller
{
    /**
     * Exibe a listagem de projetos com filtros e paginação
     */
    public function index(Request $request)
    {
        // Inicia a consulta carregando a relação com o usuário (autor) para evitar problema N+1
        $query = Projeto::with('user');

        // Filtro por busca de texto no nome do projeto
        if ($request->filled('busca')) {
            $query->where('nome', 'like', '%' . $request->busca . '%');
        }

        // Filtro por status do projeto (ex: disponível, vendido)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Ordena pelos mais recentes (ID decrescente), pagina em 9 itens por página e mantém a query string na navegação
        $projetos = $query->orderByDesc('id')->paginate(9)->withQueryString();

        // Retorna a view 'projetos.index' passando a variável $projetos
        return view('projetos.index', compact('projetos'));
    }

    /**
     * Exibe os detalhes de um projeto específico
     */
    public function show(Projeto $projeto)
    {
        // Carrega a relação com a usuária que publicou o projeto (evita consulta repetida na view)
        $projeto->loadMissing('user');

        return view('projetos.show', compact('projeto'));
    }

    /**
     * Exibe o formulário de criação de um novo projeto
     */
    public function create()
    {
        if (!in_array(auth()->user()->role, ['vendedora', 'admin'])) {
            return redirect()->route('projetos.index')
                ->with('erro', 'Você não tem permissão para publicar projetos.');
        }

        return view('projetos.create');
    }

    /**
     * Armazena um novo projeto no banco de dados
     */
    public function store(Request $request)
    {
        // Trava de segurança: impede o envio do formulário por clientes
        if (!in_array(auth()->user()->role, ['vendedora', 'admin'])) {
            return redirect()->route('projetos.index')
                ->with('erro', 'Você não tem permissão para publicar projetos.');
        }
        // 1. Validação adaptada aos campos do formulário e migration
        $request->validate([
            'nome'        => 'required|string|max:255',
            'preco'       => 'required|numeric|min:0',
            'descricao'   => 'nullable|string',
            'status'      => 'required|in:disponivel,vendido',
            'imagem_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Valida se é imagem
        ]);

        // 2. Prepara os dados base
        $dados = [
            'nome'      => $request->nome,
            'preco'     => $request->preco,
            'descricao' => $request->descricao,
            'status'    => $request->status,
            'user_id'   => auth()->id(), // Pega o id do usuário logado
        ];

        // 3. Processa o upload da imagem (se tiver sido enviada)
        if ($request->hasFile('imagem_file') && $request->file('imagem_file')->isValid()) {
            // Salva o arquivo na pasta 'storage/app/public/projetos'
            $caminhoImagem = $request->file('imagem_file')->store('projetos', 'public');
            // Monta o caminho relativo da imagem
            $dados['imagem'] = '/storage/' . $caminhoImagem;
        }

        // 4. Cria o registro no banco MySQL
        Projeto::create($dados);

        // Redireciona para a listagem com mensagem de sucesso
        return redirect()->route('projetos.index')
            ->with('success', 'Projeto publicado com sucesso!');
    }

    /**
     * Atualiza os dados de um projeto existente
     */
    public function update(Request $request, Projeto $projeto)
    {
        // Valida as alterações recebidas
        $dadosValidados = $request->validate([
            'nome'      => 'required|string|max:255',
            'preco'     => 'required|numeric|min:0',
            'descricao' => 'nullable|string',
            'status'    => 'required|in:disponivel,vendido',
            'imagem'    => 'nullable|string',
        ]);

        // Atualiza a instância do projeto com os dados validados
        $projeto->update($dadosValidados);

        // Redireciona para a listagem com mensagem de sucesso
        return redirect()->route('projetos.index')
            ->with('success', 'Projeto atualizado com sucesso!');
    }

    /**
     * Remove um projeto do banco de dados
     */
    public function destroy(Projeto $projeto)
    {
        // Exclui o projeto do banco de dados
        $projeto->delete();
        
        // Redireciona para a listagem com mensagem de sucesso
        return redirect()->route('projetos.index')
            ->with('success', 'Projeto excluído com sucesso!');
    }
}