<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; // Importa a classe genérica de Model do Eloquent

class Vendedora extends Model
{
    use HasFactory;

    // Define explicitamente o nome da tabela associada no banco de dados
    protected $table = 'vendedoras';

    // Lista de atributos permitidos para atribuição em massa
    protected $fillable = [
        'user_id',
        'nome',
        'email',
        'password',
        'CPF',
        'telefone',
        'data_nascimento',
        'CEP',
        'rua',
        'bairro',
        'cidade',
        'estado',
        'numero',
        'role',
    ];

    // Oculta informações sensíveis nas respostas de API e arrays
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Define o relacionamento 1:1 inverso — Pertence a um usuário principal de autenticação
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Define o relacionamento 1:N — Uma vendedora possui muitos projetos
    public function projetos()
    {
        // O 1º 'user_id' é a coluna da tabela 'projetos'
        // O 2º 'user_id' é a coluna da tabela 'vendedoras'
        return $this->hasMany(Projeto::class, 'user_id', 'user_id');
    }

    // Define o relacionamento 1:N — Uma vendedora possui muitas avaliações recebidas
    public function avaliacoes()
    {
        return $this->hasMany(Avaliacao::class, 'vendedora_id');
    }
}