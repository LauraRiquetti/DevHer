<?php

namespace App\Http\Controllers;

// Importação da Model Curso e das utilidades do Laravel/Carbon
use App\Models\Curso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CursoController extends Controller
{
    /**
     * Exibe a lista de cursos e calcula a idade da usuária logada
     */
    public function index()
    {
        // Busca todos os cursos do mais recente para o mais antigo
        $cursos = Curso::orderByDesc('id')->get();

        // Variável para armazenar a idade
        $idadeUsuaria = null;
        
        // Se a usuária estiver autenticada e possuir a data de nascimento cadastrada
        if (Auth::check() && Auth::user()->data_nascimento) {
            // Calcula a idade atual usando Carbon a partir do campo data_nascimento
            $idadeUsuaria = Carbon::parse(Auth::user()->data_nascimento)->age;
        }

        // Retorna a view passando a lista de cursos e a idade da usuária
        return view('cursos.index', compact('cursos', 'idadeUsuaria'));
    }

    /**
     * Exibe o formulário de cadastro de cursos (apenas para vendedoras)
     */
    public function create()
    {
        // Redireciona para o login caso a usuária não esteja autenticada
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Você precisa estar logada para cadastrar um curso.');
        }

        // Interrompe com HTTP 403 caso o perfil do usuário não seja "vendedora"
        if (Auth::user()->tipo !== 'vendedora') {
            abort(403, 'Acesso não autorizado. Apenas usuárias do tipo vendedora podem publicar cursos.');
        }

        return view('cursos.create');
    }

    /**
     * Armazena um novo curso no banco de dados
     */
    public function store(Request $request)
    {
        // Garante que apenas vendedoras autenticadas executem a ação
        if (!Auth::check() || Auth::user()->tipo !== 'vendedora') {
            abort(403, 'Apenas vendedoras podem criar cursos.');
        }

        // Valida os campos recebidos da requisição
        $dadosValidados = $request->validate([
            'nome'      => 'required|string|max:255',
            'preco'     => 'required|numeric|min:0',
            'descricao' => 'nullable|string',
            'imagem'    => 'nullable|string',
            'categoria' => 'nullable|string',
        ]);

        // Atribui o ID do usuário autenticado ao curso
        $dadosValidados['user_id'] = Auth::id();

        // Salva o novo curso no banco de dados
        Curso::create($dadosValidados);

        return redirect()->route('cursos.index')
            ->with('success', 'Curso cadastrado com sucesso!');
    }

    /**
     * Atualiza um curso existente
     */
    public function update(Request $request, Curso $curso)
    {
        // Verifica se a usuária está logada e se é a dona do curso
        if (!Auth::check() || Auth::user()->id !== $curso->user_id) {
            abort(403, 'Você não tem permissão para alterar este curso.');
        }

        // Valida os dados
        $dadosValidados = $request->validate([
            'nome'      => 'required|string|max:255',
            'preco'     => 'required|numeric|min:0',
            'descricao' => 'nullable|string',
            'imagem'    => 'nullable|string',
            'categoria' => 'nullable|string',
        ]);

        // Aplica as alterações no curso
        $curso->update($dadosValidados);

        return redirect()->route('cursos.index')
            ->with('success', 'Curso atualizado com sucesso!');
    }

    /**
     * Exclui um curso
     */
    public function destroy(Curso $curso) 
    {
        // Verifica se a usuária está logada e se é a dona do curso
        if (!Auth::check() || Auth::user()->id !== $curso->user_id) {
            abort(403, 'Você não tem permissão para excluir este curso.');
        }

        // Deleta o curso
        $curso->delete();
        
        return redirect()->route('cursos.index')
            ->with('success', 'Curso excluído com sucesso!');
    }

    /**
     * Filtra e exibe cursos por categoria específica
     */
    public function porCategoria($categoria)
    {
        // Busca todos os cursos pertencentes à categoria fornecida na URL
        $cursos = Curso::where('categoria', $categoria)->get();
        
        // Retorna a view da loja com os cursos filtrados e a categoria ativa
        return view('loja.home', compact('cursos', 'categoria'));
    }
}