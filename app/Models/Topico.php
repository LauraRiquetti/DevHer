<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topico extends Model
{
    use HasFactory;

    protected $fillable = [
        'comunidade_id',
        'user_id',
        'titulo',
        'mensagem',
    ];

    public function comunidade()
    {
        return $this->belongsTo(Comunidade::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function respostas()
    {
        return $this->hasMany(Resposta::class)->oldest();
    }
}