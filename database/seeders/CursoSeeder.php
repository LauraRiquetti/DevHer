<?php
// database/seeders/CursoSeeder.php

namespace Database\Seeders;

use App\Models\Curso;
use App\Models\User;
use Illuminate\Database\Seeder;

class CursoSeeder extends Seeder
{
    public function run(): void
    {
        // Reaproveita usuárias já existentes (as mesmas usadas nos projetos, por exemplo)
        $userIds = User::pluck('id');

        if ($userIds->isEmpty()) {
            $userIds = User::factory()->count(6)->create()->pluck('id');
        }

        Curso::factory()
            ->count(15)
            ->make()
            ->each(function (Curso $curso) use ($userIds) {
                $curso->user_id = $userIds->random();
                $curso->save();
            });
    }
}