<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Projeto; // Importa o model de Projetos
use App\Models\Curso;   // Importa o model de Cursos

class HomeController extends Controller
{
    public function index()
    {
        // Busca os registros mais recentes de cada um
        $projetos = Projeto::orderByDesc('id')->get();
        $cursos   = Curso::orderByDesc('id')->get();
        
        // Define 'todos' para manter a lógica de categoria que você já tinha
        $categoria = 'todos'; 

        // Passa as duas coleções para a view 'loja.home'
        return view('loja.home', compact('projetos', 'cursos', 'categoria'));
    }
}