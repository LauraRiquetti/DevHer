<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Deleta qualquer usuário com esse email para limpar o erro de duplicidade
        DB::table('users')->where('email', 'adm@email.com')->delete();

        // 2. Cria o Admin do zero com os dados exatos
        User::create([
            'name'     => 'Admin',
            'email'    => 'adm@email.com',
            'password' => Hash::make('12345678'),
            'role'     => 'admin', // Usando a coluna que o seu erro SQL mostrou
        ]);

        $this->command->info('Admin criado: adm@email.com | Senha: 12345678');
    }
}