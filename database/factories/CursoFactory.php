<?php
// database/factories/CursoFactory.php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CursoFactory extends Factory
{
    public function definition(): array
    {
        $nomes = [
            'Fundamentos de JavaScript',
            'React do Zero ao Avançado',
            'Laravel para Iniciantes',
            'UX Research na Prática',
            'Design System com Figma',
            'Python para Análise de Dados',
            'Introdução a DevOps',
            'Segurança em Aplicações Web',
            'Banco de Dados com MySQL',
            'Mobile com Flutter',
        ];

        $categorias = [
            'Front-end',
            'Back-end',
            'UX/UI',
            'Dados',
            'DevOps',
            'Mobile',
            'Carreira',
        ];

        return [
            'nome'      => fake()->randomElement($nomes) . ' #' . fake()->unique()->numberBetween(1, 9999),
            // 'descricao' é string (varchar 255) na migration, então usamos sentence() e não paragraph()
            'descricao' => fake()->sentence(12),
            'preco'     => fake()->randomElement([0, 0, fake()->randomFloat(2, 29, 899)]), // alguns gratuitos, outros pagos
            'categoria' => fake()->randomElement($categorias),
            'imagem'    => fake()->boolean(70)
                ? 'https://picsum.photos/seed/' . fake()->uuid() . '/600/400'
                : null,
            'user_id'   => User::factory(),
        ];
    }
}