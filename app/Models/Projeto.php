<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projeto extends Model // 👈 Alterado de Equipamento para Projeto
{
    use HasFactory;
    
    protected $table = 'projetos';

    protected $fillable = [
        'nome',
        'preco',       // 👈 Note que no Model está 'preco', mas no seeder você usou 'valor'
        'quantidade',  // 👈 Adicionado para o Seeder funcionar
        'descricao',
        'status',
        'imagem',
        'user_id',
    ];

    /**
     * Relacionamento: Um projeto pertence a um usuário (criador/responsável).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected function venda()
    {
        return $this->hasMany(Venda::class);
    }
}