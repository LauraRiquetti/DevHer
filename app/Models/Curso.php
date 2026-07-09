<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;
     protected $table = 'cursos';

    protected $fillable = [
        'nome',
        'preco',
        'descricao',
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
