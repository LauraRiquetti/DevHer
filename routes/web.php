<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VendedoraController;
use App\Http\Controllers\UsuarioController;

/*
|--------------------------------------------------------------------------
| Rotas do DevHer
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Login
Route::get('/login', [VendedoraController::class, 'showLogin'])->name('login');
Route::post('/login', [VendedoraController::class, 'login'])->name('login');
Route::post('/logout', [VendedoraController::class, 'logout'])->name('logout');

// Cadastro (RF01)
Route::get('/cadastro', [VendedoraController::class, 'create'])->name('cadastro');
Route::post('/cadastro', [VendedoraController::class, 'store'])->name('vendedoras.store');

// Vendedoras (listagem / edição / exclusão)
Route::get('/vendedoras', [VendedoraController::class, 'index'])->name('vendedoras.index');
Route::put('/vendedoras/{vendedora}', [VendedoraController::class, 'update'])->name('vendedoras.update');
Route::delete('/vendedoras/{vendedora}', [VendedoraController::class, 'destroy'])->name('vendedoras.destroy');

// Busca de CEP (usada pelo JS da tela de cadastro)
Route::get('/cep/{cep}', [VendedoraController::class, 'buscarCep'])->name('cep.buscar');

// Recuperação de senha (telas prontas; ligar depois a um Controller de verdade)
Route::view('/esqueci-senha', 'Auth.forgot-password')->name('password.request');
Route::view('/redefinir-senha/{token}', 'Auth.reset-password')->name('password.reset');

// Marketplace de projetos (RF02, RF03, RF04)
Route::view('/projetos', 'Projetos.index')->name('projetos.index');
Route::view('/projetos/novo', 'Projetos.create')->name('projetos.create');

// Carrinho e checkout (RF04)
Route::post('/carrinho', function () { return back(); })->name('carrinho.add');
Route::delete('/carrinho/{index}', function ($index) { return back(); })->name('carrinho.remove');
Route::post('/carrinho/checkout', function () { return redirect()->route('carrinho.sucesso'); })->name('carrinho.checkout');
Route::view('/carrinho', 'Carrinho.index')->name('carrinho.index');
Route::view('/carrinho/sucesso', 'Carrinho.sucesso')->name('carrinho.sucesso');
Route::view('/meus-pedidos', 'Loja.meus_pedidos')->name('meus-pedidos');

// Cursos (RF05, RF06)
Route::view('/cursos', 'Cursos.index')->name('cursos.index');

// Perfil público da criadora (RF07, RF08) + avaliações
Route::get('/criadoras/{id}', function ($id) { return view('Criadoras.perfil'); })->name('criadoras.perfil');
Route::post('/avaliacoes', function () { return back(); })->name('avaliacoes.store');

// Painel administrativo (RF09) — proteger com middleware depois
Route::view('/admin', 'admin.dashboard')->name('admin.dashboard');
Route::view('/admin/relatorio', 'admin.relatorio')->name('admin.relatorio');
Route::post('/admin/{id}/aprovar', function ($id) { return back(); })->name('admin.aprovar');
Route::delete('/admin/{id}/remover', function ($id) { return back(); })->name('admin.remover');

// Usuárias (se você mantiver uma tela separada de Usuarios/, ligue a um UsuarioController)
// Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
// Route::get('/usuarios/novo', [UsuarioController::class, 'create'])->name('usuarios.create');
// Route::get('/usuarios/{id}/editar', [UsuarioController::class, 'edit'])->name('usuarios.edit');