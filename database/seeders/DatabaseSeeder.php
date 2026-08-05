<?php

namespace Database\Seeders;

// Importação do Seeder base do Laravel
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Ponto de entrada principal para rodar todas as Seeders do projeto (php artisan db:seed)
     */
    public function run(): void
    {
        // Chama e executa as outras classes de Seeder na ordem definida
        $this->call([
            AdminSeeder::class, // Executa o cadastro automático do Admin
            ComunidadeSeeder::class,
            ProjetoSeeder::class,
            CursoSeeder::class,
        ]);
    }
}