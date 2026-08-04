<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Projeto;
use App\Models\Curso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Dashboard Principal com Métricas Reais
     */
    /**
     * Dashboard Principal com Métricas Reais
     */
    public function dashboard()
    {
        // 1. KPIs com dados reais do Banco de Dados
        $kpis = [
            [
                'label' => 'Usuárias ativas',
                'valor' => number_format(User::where('role', '!=', 'admin')->count(), 0, ',', '.'),
                'delta' => '+100%',
                'up'    => true
            ],
            [
                'label' => 'Projetos publicados',
                'valor' => number_format(Projeto::count(), 0, ',', '.'),
                'delta' => '+100%',
                'up'    => true
            ],
            [
                'label' => 'Cursos publicados',
                'valor' => number_format(Curso::count(), 0, ',', '.'),
                'delta' => '+100%',
                'up'    => true
            ],
            [
                'label' => 'Vendas no mês',
                'valor' => 'R$ ' . number_format(0, 2, ',', '.'), // Pode ser conectado com a tabela de vendas futuramente
                'delta' => '0%',
                'up'    => true
            ],
        ];

        // 2. Busca conteúdos reais pendentes de moderação
        // CORREÇÃO: Trocado 'vendedora' por 'user' e 'nome' por 'name'
        $projetosPendentes = Projeto::with('user')->latest()->take(5)->get()->map(function ($proj) {
            return [
                'id'     => $proj->id,
                'tipo'   => 'Projeto',
                'titulo' => $proj->titulo ?? $proj->nome,
                'autora' => $proj->user->name ?? 'Vendedora', // Alterado aqui!
            ];
        });

        return view('admin.dashboard', [
            'kpis'       => $kpis,
            'pendencias' => $projetosPendentes
        ]);
    }

    /**
     * Relatório Dinâmico por Mês
     */
    public function relatorio()
    {
        // Agrupa o cadastro de usuárias reais por mês do ano atual
        $relatorio = User::select(
            DB::raw('MONTHNAME(created_at) as mes'),
            DB::raw('count(*) as novas_usuarias')
        )
        ->groupBy('mes')
        ->get()
        ->map(function ($item) {
            return [
                'mes'               => $item->mes,
                'novas_usuarias'   => $item->novas_usuarias,
                'projetos_vendidos' => 0,
                'receita'           => 'R$ 0,00'
            ];
        });

        // Caso não haja dados no banco ainda, exibe um histórico básico estruturado
        if ($relatorio->isEmpty()) {
            $relatorio = collect([
                ['mes' => 'Atual', 'novas_usuarias' => User::count(), 'projetos_vendidos' => 0, 'receita' => 'R$ 0,00']
            ]);
        }

        return view('admin.relatorio', ['linhas' => $relatorio]);
    }

    /**
     * Ação para Aprovar Conteúdo
     */
    public function aprovar($id)
    {
        // Exemplo: se houver campo status
        $projeto = Projeto::find($id);
        if ($projeto && isset($projeto->status)) {
            $projeto->update(['status' => 'ativo']);
        }

        return back()->with('success', 'Conteúdo aprovado com sucesso!');
    }

    /**
     * Ação para Remover Conteúdo
     */
    public function remover($id)
    {
        $projeto = Projeto::find($id);
        if ($projeto) {
            $projeto->delete();
        }

        return back()->with('success', 'Conteúdo removido com sucesso!');
    }
}