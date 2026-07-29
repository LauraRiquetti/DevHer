<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avaliacao extends Model
{
    use HasFactory;

    protected $table = 'avaliacaos';

    protected $fillable = [
        'user_id',
        'vendedora_id',
        'comentario',
        'nota',
    ];

    // Usuária/Cliente que escreveu a avaliação
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Vendedora que recebeu a avaliação
    public function vendedora()
    {
        return $this->belongsTo(Vendedora::class);
    }
}