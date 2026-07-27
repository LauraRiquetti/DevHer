<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Projeto;
use App\Models\Curso;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $projetos = Projeto::orderByDesc('id')->get();
        $cursos   = Curso::orderByDesc('id')->get();
        
        // Dados para os contadores e a constelação da welcome
        $vendedoras     = User::latest()->take(6)->get();
        $totalProjetos  = Projeto::count();
        $totalCriadoras = User::count();

        // Altere 'loja.home' para 'welcome' para que os dados cheguem na landing page
        return view('welcome', compact(
            'projetos', 
            'cursos', 
            'vendedoras', 
            'totalProjetos', 
            'totalCriadoras'
        ));
    }
}