<?php


use Illuminate\Support\Facades\Route;

// Importação dos Controllers usados nas rotas
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AvaliacaoController;
use App\Http\Controllers\CarrinhoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PagamentoController;
use App\Http\Controllers\ProjetoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VendedoraController;


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
Route::post('/redefinir-senha', [AuthController::class, 'updatePassword'])->name('password.update');
Route::view('/redefinir-senha/{token}', 'auth.reset-password')->name('password.reset');

// Catálogos e Vitrines
Route::get('/projetos', [ProjetoController::class, 'index'])->name('projetos.index');
Route::get('/cursos', [CursoController::class, 'index'])->name('cursos.index');

// Vendedoras / Criadoras / Perfil Público
Route::get('/vendedoras', [VendedoraController::class, 'index'])->name('vendedoras.index');
Route::get('/vendedoras/{id}', [VendedoraController::class, 'show'])->name('vendedoras.perfil');
// Alias/Atalho para a rota `criadoras.show` usada na Navbar
Route::get('/criadoras/{id}', [VendedoraController::class, 'show'])->name('criadoras.show');

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

    // --- ÁREA DO CLIENTE (Perfis e Edição) ---
    Route::get('/clientes/{id}', function ($id) { return view('clientes.perfil'); })->name('clientes.show');
    Route::get('/clientes/{id}/editar', function ($id) { return view('clientes.edit'); })->name('clientes.edit');
    Route::put('/clientes/{id}', [ClienteController::class, 'update'])->name('clientes.update');

    // Gerenciamento de Conta / Vendedora
    Route::put('/vendedoras/{vendedora}', [VendedoraController::class, 'update'])->name('vendedoras.update');
    Route::delete('/vendedoras/{vendedora}', [VendedoraController::class, 'destroy'])->name('vendedoras.destroy');

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

    // Rota para salvar a avaliação enviada pelo formulário
    Route::post('/avaliacoes', [AvaliacaoController::class, 'store'])
        ->middleware('auth')
        ->name('avaliacoes.store');
});

// Rota para receber notificações automáticas de pagamento do Mercado Pago
Route::post('/pagamento/notification', [PagamentoController::class, 'notificacao'])->name('pagamento.notificacao');
Route::post('/carrinho/adicionar/{tipo}/{id}', [App\Http\Controllers\CarrinhoController::class, 'adicionar'])->name('carrinho.add');
Route::post('/carrinho/adicionar/{tipo}/{id}', [CarrinhoController::class, 'adicionar'])->name('carrinho.add');

// Página de detalhes do curso (pública). Importante: fica DEPOIS de '/cursos/novo'
// (lá em cima, dentro do grupo 'auth') para que '/cursos/novo' continue sendo
// reconhecida corretamente e não seja capturada por esse parâmetro genérico {curso}.
Route::get('/cursos/{curso}', [CursoController::class, 'show'])->name('cursos.show');

// Página de detalhes do projeto (pública). Mesmo motivo acima: fica DEPOIS de
// '/projetos/novo' para essa rota específica continuar funcionando normalmente.
Route::get('/projetos/{projeto}', [ProjetoController::class, 'show'])->name('projetos.show');


/*
|--------------------------------------------------------------------------
| ROTAS ADMINISTRATIVAS (Apenas Administradores)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/relatorio', [AdminController::class, 'relatorio'])->name('relatorio');
    Route::post('/aprovar/{id}', [AdminController::class, 'aprovar'])->name('aprovar');
    Route::delete('/remover/{id}', [AdminController::class, 'remover'])->name('remover');

});

/*
|--------------------------------------------------------------------------
| MONITORAMENTO DE CRIADORAS (Para a área administrativa de criadoras)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/criadoras', function () { return view('criadoras.index'); })->name('criadoras.index');
    Route::get('/criadoras/criar', function () { return view('criadoras.create'); })->name('criadoras.create');
    Route::get('/criadoras/{id}/editar', function ($id) { return view('criadoras.edit'); })->name('criadoras.edit');
    Route::put('/criadoras/{id}', [VendedoraController::class, 'update'])->name('criadoras.update');
});