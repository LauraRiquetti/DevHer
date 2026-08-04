<?php
// database/seeders/ProjetoSeeder.php

namespace Database\Seeders;

use App\Models\Projeto;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjetoSeeder extends Seeder
{
    public function run(): void
    {
        // Reaproveita usuárias já existentes; se não houver nenhuma, cria algumas
        $userIds = User::pluck('id');

        if ($userIds->isEmpty()) {
            $userIds = User::factory()->count(6)->create()->pluck('id');
        }

        // Gera 20 projetos, cada um vinculado a uma usuária existente aleatória
        Projeto::factory()
            ->count(20)
            ->make()
            ->each(function (Projeto $projeto) use ($userIds) {
                $projeto->user_id = $userIds->random();
                $projeto->save();
            });
    }
}