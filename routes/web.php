<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VendedoraController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjetoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\CarrinhoController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PagamentoController; // Adicionado import que faltava

/*
|--------------------------------------------------------------------------
| ROTAS PÚBLICAS (Acessíveis a qualquer visitante)
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// Autenticação e Cadastro
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/cadastro', [AuthController::class, 'showRegisterForm'])->name('cadastro');
Route::post('/cadastro', [AuthController::class, 'register'])->name('cadastro.store');

// Recuperação de senha via E-mail (Gmail)
Route::get('/esqueci-senha', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/esqueci-senha', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::view('/redefinir-senha/{token}', 'auth.reset-password')->name('password.reset');

// Catálogos e Vitrines
Route::get('/projetos', [ProjetoController::class, 'index'])->name('projetos.index');
Route::get('/cursos', [CursoController::class, 'index'])->name('cursos.index');

// Vendedoras / Perfil Público
Route::get('/vendedoras', [VendedoraController::class, 'index'])->name('vendedoras.index');
Route::get('/vendedoras/{id}', function ($id) { return view('vendedoras.perfil'); })->name('vendedoras.perfil');
Route::get('/cep/{cep}', [VendedoraController::class, 'buscarCep'])->name('cep.buscar');

// Carrinho de Compras (Usa Session, por isso é público)
Route::get('/carrinho', [CarrinhoController::class, 'index'])->name('carrinho.index');
Route::post('/carrinho/adicionar/{tipo}/{id}', [CarrinhoController::class, 'adicionar'])->name('carrinho.adicionar');
Route::delete('/carrinho/remover/{chave}', [CarrinhoController::class, 'remover'])->name('carrinho.remover');
Route::post('/carrinho/limpar', [CarrinhoController::class, 'limpar'])->name('carrinho.limpar');


/*
|--------------------------------------------------------------------------
| ROTAS AUTENTICADAS (Apenas usuários logados)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    
    // Dashboard Comum (Vendedoras e Clientes)
    Route::get('/dashboard', [VendedoraController::class, 'index'])->name('dashboard');

    // Gerenciamento de Conta / Vendedora
    Route::put('/vendedoras/{vendedora}', [VendedoraController::class, 'update'])->name('vendedoras.update');
    Route::delete('/vendedoras/{vendedora}', [VendedoraController::class, 'destroy'])->name('vendedoras.destroy');
    Route::post('/avaliacoes', function () { return back(); })->name('avaliacoes.store');

    // Gerenciamento de Projetos (Criar, Editar, Deletar)
    Route::get('/projetos/novo', [ProjetoController::class, 'create'])->name('projetos.create');
    Route::post('/projetos', [ProjetoController::class, 'store'])->name('projetos.store');
    Route::put('/projetos/{projeto}', [ProjetoController::class, 'update'])->name('projetos.update');
    Route::delete('/projetos/{projeto}', [ProjetoController::class, 'destroy'])->name('projetos.destroy');

    // Gerenciamento de Cursos (Criar)
    Route::get('/cursos/novo', [CursoController::class, 'create'])->name('cursos.create');
    Route::post('/cursos', [CursoController::class, 'store'])->name('cursos.store');

    // Pedidos e Checkout de Pagamento
    Route::view('/meus-pedidos', 'Loja.meus_pedidos')->name('meus-pedidos');
    Route::post('/checkout/processar', [PagamentoController::class, 'processar'])->name('pagamento.processar');
    Route::get('/pagamento/sucesso', [PagamentoController::class, 'sucesso'])->name('pagamento.sucesso');
    Route::get('/pagamento/falha', [PagamentoController::class, 'falha'])->name('pagamento.falha');
    Route::get('/pagamento/pendente', [PagamentoController::class, 'pendente'])->name('pagamento.pendente');

});


/*
|--------------------------------------------------------------------------
| ROTAS ADMINISTRATIVAS (Apenas Administradores)
|--------------------------------------------------------------------------
*/
// O "prefix" adiciona '/admin' na URL. O "name" adiciona 'admin.' no nome da rota.
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Voltamos para '/' para que a URL seja exatamente '/admin' e não quebre o AuthController
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    
    Route::get('/relatorio', [AdminController::class, 'relatorio'])->name('relatorio');
    Route::post('/aprovar/{id}', [AdminController::class, 'aprovar'])->name('aprovar');
    Route::delete('/remover/{id}', [AdminController::class, 'remover'])->name('remover');

});