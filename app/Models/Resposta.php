<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resposta extends Model
{
    use HasFactory;

    protected $fillable = [
        'topico_id',
        'user_id',
        'mensagem',
    ];

    public function topico()
    {
        return $this->belongsTo(Topico::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}