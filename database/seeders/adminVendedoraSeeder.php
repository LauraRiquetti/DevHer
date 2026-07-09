<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Vendedora;

class AdminVendedoraSeeder extends Seeder
{
    /**
     * Cria (ou atualiza) uma vendedora/administradora fixa para testes.
     *
     * Login:  admin@devher.com
     * Senha:  Admin@123
     *
     * Rodar com: php artisan db:seed --class=AdminVendedoraSeeder
     */
    public function run(): void
    {
        Vendedora::updateOrCreate(
            ['email' => 'admin@devher.com'],
            [
                'nome' => 'Administradora DevHer',
                'password' => Hash::make('Admin@123'),
                'data_nascimento' => '1990-01-01',
                'CEP' => '01001000',
                'rua' => 'Praça da Sé',
                'bairro' => 'Sé',
                'cidade' => 'São Paulo',
                'estado' => 'SP',
                'numero' => '1',
            ]
        );

        $this->command->info('Admin criada: admin@devher.com / Admin@123');
    }
}