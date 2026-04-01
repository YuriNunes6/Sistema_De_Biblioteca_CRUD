<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LivroController;
use App\Http\Controllers\EmprestimoController;
use App\Http\Controllers\UserController;
use App\Models\Livro;
use App\Models\Emprestimo;

/*
|--------------------------------------------------------------------------
| ROTAS DE AUTENTICAÇÃO
|--------------------------------------------------------------------------
*/

// Cadastro
Route::get('/register', [AuthController::class, 'showCadastro'])->name('register');
Route::post('/register', [AuthController::class, 'cadastroSubmit'])->name('register.submit');

// Login
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/', [AuthController::class, 'login'])->name('login.submit');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| ROTAS PROTEGIDAS (usuário logado)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        $totalLivros = Livro::count();
        $livrosDisponiveis = Livro::sum('quantidade');
        $livrosEmprestados = Emprestimo::where('status', 'emprestado')->count();
        $emprestimosConcluidos = Emprestimo::where('status', 'devolvido')->count();

        // Carrega os últimos 5 empréstimos
        $ultimosEmprestimos = Emprestimo::with('livro')->orderBy('data_emprestimo', 'desc')->take(5)->get();

        return view('user.dashboard', compact(
            'totalLivros',
            'livrosDisponiveis',
            'livrosEmprestados',
            'emprestimosConcluidos',
            'ultimosEmprestimos' // <-- adiciona aqui
        ));
    })->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | USUÁRIO
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::get('/profile/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/profile/update', [UserController::class, 'update'])->name('user.update');

    /*
    |--------------------------------------------------------------------------
    | LIVROS (CRUD)
    |--------------------------------------------------------------------------
    */
    Route::resource('livros', LivroController::class);

    /*
    |--------------------------------------------------------------------------
    | EMPRÉSTIMOS (CRUD)
    |--------------------------------------------------------------------------
    */
    Route::resource('emprestimos', EmprestimoController::class);
});