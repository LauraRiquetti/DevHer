<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comunidade extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'slug',
        'descricao',
    ];

    /**
     * Usa o slug em vez do id nas rotas (ex: /comunidades/pyladies)
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function topicos()
    {
        return $this->hasMany(Topico::class)->latest();
    }
}