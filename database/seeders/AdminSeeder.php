<?php

namespace Database\Seeders;

// Importação da Model User e do Seeder base do Laravel
use App\Models\User;
use Illuminate\Database\Seeder;

// Importação do Facade Hash para criptografia de senhas
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Executa as sementes do banco de dados para criar o usuário administrador
     */
    public function run(): void
    {
        // Procura um usuário pelo e-mail; se encontrar, atualiza os dados, caso contrário, cria um novo
        User::updateOrCreate(
            ['email' => 'admin@devher.com.br'], // Chave de busca para evitar duplicidade
            [
                'name'     => 'Administrador DevHer',
                'password' => Hash::make('12345678'), // Criptografa a senha do admin
                'role'     => 'admin',               // Define o nível de acesso como administrador
            ]
        );
    }
}