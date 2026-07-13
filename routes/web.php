<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VendedoraController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Rotas do DevHer
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// ==========================================
// FLUXO DE AUTENTICAÇÃO CENTRALIZADO (AuthController)
// ==========================================

// Login Geral (Clientes, Admins)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Cadastro Único (Aquela view auth/cadastro que revisamos)
Route::get('/cadastro', [AuthController::class, 'showRegisterForm'])->name('cadastro');
Route::post('/cadastro', [AuthController::class, 'register'])->name('cadastro.store');

// Recuperação de senha via Gmail
Route::get('/esqueci-senha', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/esqueci-senha', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::view('/redefinir-senha/{token}', 'auth.reset-password')->name('password.reset');


// ==========================================
// FLUXO EXCLUSIVO DE VENDEDORAS (VendedoraController)
// ==========================================

// Gerenciamento de Vendedoras (Painel Admin/Listagens)
Route::get('/vendedoras', [VendedoraController::class, 'index'])->name('vendedoras.index');
Route::put('/vendedoras/{vendedora}', [VendedoraController::class, 'update'])->name('vendedoras.update');
Route::delete('/vendedoras/{vendedora}', [VendedoraController::class, 'destroy'])->name('vendedoras.destroy');

// Perfil público da vendedora (Ajustado o nome de Criadoras para Vendedoras)
Route::get('/vendedoras/{id}', function ($id) { return view('vendedoras.perfil'); })->name('vendedoras.perfil');
Route::post('/avaliacoes', function () { return back(); })->name('avaliacoes.store');

// Utilitário de CEP usado no JS do cadastro
Route::get('/cep/{cep}', [VendedoraController::class, 'buscarCep'])->name('cep.buscar');


// ==========================================
// MARKETPLACE, CARRINHO E CURSOS (Views estáticas/Ações simples)
// ==========================================

// Marketplace de projetos
Route::view('/projetos', 'Projetos.index')->name('projetos.index');
Route::view('/projetos/novo', 'Projetos.create')->name('projetos.create');

// Carrinho e checkout
Route::post('/carrinho', function () { return back(); })->name('carrinho.add');
Route::delete('/carrinho/{index}', function ($index) { return back(); })->name('carrinho.remove');
Route::post('/carrinho/checkout', function () { return redirect()->route('carrinho.sucesso'); })->name('carrinho.checkout');
Route::view('/carrinho', 'Carrinho.index')->name('carrinho.index');
Route::view('/carrinho/sucesso', 'Carrinho.sucesso')->name('carrinho.sucesso');
Route::view('/meus-pedidos', 'Loja.meus_pedidos')->name('meus-pedidos');

// Cursos
Route::view('/cursos', 'Cursos.index')->name('cursos.index');


// ==========================================
// PAINEL ADMINISTRATIVO (Admin)
// ==========================================
Route::view('/admin', 'admin.dashboard')->name('admin.dashboard');
Route::view('/admin/relatorio', 'admin.relatorio')->name('admin.relatorio');
Route::post('/admin/{id}/aprovar', function ($id) { return back(); })->name('admin.aprovar');
Route::delete('/admin/{id}/remover', function ($id) { return back(); })->name('admin.remover');