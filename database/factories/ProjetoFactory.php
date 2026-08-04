<?php
// database/factories/ProjetoFactory.php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjetoFactory extends Factory
{
    public function definition(): array
    {
        // Ideias de nomes de projetos coerentes com o tema (marketplace de tech)
        $nomes = [
            'Dashboard de Vendas em Vue',
            'Landing Page para ONGs',
            'App de Delivery Sustentável',
            'Sistema de Agendamento Médico',
            'Componente de Chat em React',
            'API de Pagamentos com Stripe',
            'Template de Portfólio Dev',
            'Bot de Automação no Discord',
            'Painel Admin em Laravel',
            'Extensão de Acessibilidade Web',
        ];

        return [
            'nome'      => fake()->randomElement($nomes) . ' #' . fake()->unique()->numberBetween(1, 9999),
            // 'descricao' é string (varchar 255) na migration, então usamos sentence() e não paragraph()
            'descricao' => fake()->sentence(12),
            'preco'     => fake()->randomFloat(2, 49, 2500),
            'status'    => fake()->randomElement(['disponivel', 'vendido']),
            'imagem'    => fake()->boolean(70)
                ? 'https://picsum.photos/seed/' . fake()->uuid() . '/600/400'
                : null,
            // Por padrão cria uma usuária nova para cada projeto;
            // no seeder vamos sobrescrever isso para reaproveitar usuárias já existentes
            'user_id'   => User::factory(),
        ];
    }
}