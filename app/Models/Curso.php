<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'preco',
        'descricao',
        'imagem',
        'categoria',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
