<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipamento extends Model
{
    use HasFactory;
    protected $table = 'projetos';

    protected $fillable = [
        'nome',
        'preco',
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