<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Permite autenticar diretamente por este Model, se necessário
use Illuminate\Notifications\Notifiable;

class Cliente extends Authenticatable
{
    use HasFactory, Notifiable;

    // Define a tabela do banco de dados mapeada pelo Model
    protected $table = 'clientes';

    // Campos liberados para cadastro e edição em massa
    protected $fillable = [
        'user_id',
        'nome',
        'email',
        'password',
        'CPF',
        'telefone', // Atributo de telefone cadastrado
        'data_nascimento',
        'CEP',
        'rua',
        'bairro',
        'cidade',
        'estado',
        'numero',
        'role',
    ];

    // Oculta a senha e o token de sessão da serialização
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relacionamento de pertencimento à tabela principal de autenticação de usuários
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relacionamento 1:N — Um cliente possui o histórico de várias vendas/compras efetuadas
    public function vendas()
    {
        return $this->hasMany(Venda::class);
    }

}