<?php

namespace App\Models;

// Interface opcional para verificação de e-mail (comentada por padrão no Laravel)
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Extende a classe base de autenticação do Laravel
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    // Traits para suporte a tokens de API (Sanctum), criação de factories para testes e envio de notificações
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Campos que podem ser preenchidos em massa via atribuição (ex: User::create)
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Campos ocultados automaticamente ao converter o Model para Array ou JSON
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Define a conversão automática de tipos de dados ao acessar esses atributos
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime', // Converte a data de verificação para objeto Carbon/DateTime
        'password'          => 'hashed',   // Criptografa a senha automaticamente no momento do salvamento
    ];
}