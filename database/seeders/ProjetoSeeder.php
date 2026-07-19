<?php

namespace Database\Seeders;

use App\Models\Projeto;
use Illuminate\Database\Seeder;

class ProjetoSeeder extends Seeder
{
    public function run(): void
    {
        $projetos = [
            // FARMÁCIA
            ["DashBoard", "projetos/dipirona-500mg.jpeg"],
            ["Paracetamol 750mg", "projetos/paracetamol-750mg.png"],
            ["Ibuprofeno 600mg",  "projetos/ibuprofeno-600mg.png"],
            ["Amoxicilina",  "projetos/amoxicilina.jpeg"],
            ["Loratadina",  "projetos/loratadina.jpeg"],
            ["Omeprazol",  "projetos/omeprazol.jpeg"],
            ["Dramin B6",  "projetos/dramin-b6.jpeg"],
            ["Buscopan",  "projetos/buscopan.jpg"],
        ];

        foreach ($projetos as $p) {
            Projeto::create([
                'nome' => $p[0],
                'imagem' => $p[2],
                'quantidade' => 50, 
                'preco' => rand(15, 95) + 0.90, // 👈 Alterado de 'valor' para 'preco' para bater com o Model
            ]);
        }
    }
}