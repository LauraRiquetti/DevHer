<?php

namespace App\Http\Controllers;

use App\Models\Projeto;
use Illuminate\Http\Request;

class ProjetoController extends Controller
{
    public function index(Request $request)
    {
        $query = Projeto::with('user'); // Carrega a relação para buscar o nome do autor

        // Filtro por busca de texto no nome do projeto
        if ($request->filled('busca')) {
            $query->where('nome', 'like', '%' . $request->busca . '%');
        }

        // Filtro por status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $projetos = $query->orderByDesc('id')->paginate(9)->withQueryString();

        return view('projetos.index', compact('projetos'));
    }

    public function create()
    {
        return view('projetos.create');
    }

    public function store(Request $request)
    {
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
            $caminhoImagem = $request->file('imagem_file')->store('projetos', 'public');
            $dados['imagem'] = '/storage/' . $caminhoImagem;
        }

        // 4. Cria o registro no banco MySQL
        Projeto::create($dados);

        return redirect()->route('projetos.index')
            ->with('success', 'Projeto publicado com sucesso!');
    }
    public function update(Request $request, Projeto $projeto)
    {
        $dadosValidados = $request->validate([
            'nome'      => 'required|string|max:255',
            'preco'     => 'required|numeric|min:0',
            'descricao' => 'nullable|string',
            'status'    => 'required|in:disponivel,vendido',
            'imagem'    => 'nullable|string',
        ]);

        $projeto->update($dadosValidados);

        return redirect()->route('projetos.index')
            ->with('success', 'Projeto atualizado com sucesso!');
    }

    public function destroy(Projeto $projeto)
    {
        $projeto->delete();
        
        return redirect()->route('projetos.index')
            ->with('success', 'Projeto excluído com sucesso!');
    }
}