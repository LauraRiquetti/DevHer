<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendedora extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'vendedoras';

    protected $fillable = [
        'user_id',
        'nome',
        'email',
        'password',
        'data_nascimento',
        'CEP',
        'rua',
        'bairro',
        'cidade',
        'estado',
        'numero',
        'role' 
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vendas()
    {
        return $this->hasMany(Venda::class);
    }

}
