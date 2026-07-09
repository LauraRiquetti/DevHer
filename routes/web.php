<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VendedoraController;
use App\Http\Controllers\UsuarioController;

Route::get('/', function () {
    return view('auth.login');
})->name('login');
Route::get('/login', [VendedoraController::class, 'showLogin'])->name('login');

// Rota que mostra o formulário de cadastro (View vendedoras.create)
Route::get('/cadastro', [VendedoraController::class, 'create'])->name('cadastro');
