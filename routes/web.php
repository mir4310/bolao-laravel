<?php

use App\Http\Controllers\ChuteDeOuroController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminGameController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AvatarController;
use App\Http\Controllers\PalpiteController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/jogos-apostas/{id}', [SiteController::class, 'jogoApostas']);


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [PalpiteController::class, 'index'])->name('dashboard');
    Route::post('/palpites', [PalpiteController::class, 'store'])->name('palpites.store');
    Route::post('/chute-de-ouro', [ChuteDeOuroController::class, 'store'])->name('chute-de-ouro.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/ranking', [RankingController::class, 'index'])->name('ranking.index');
    Route::get('/regulamento', [SiteController::class, 'regulamento'])->name('regulamento');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    Route::get('/admin/games', [AdminGameController::class, 'index'])->name('admin.games.index');
    Route::get('/admin/games/create', [AdminGameController::class, 'create'])->name('admin.games.create');
    Route::post('/admin/games', [AdminGameController::class, 'store'])->name('admin.games.store');
    Route::get('/admin/games/{game}/edit', [AdminGameController::class, 'edit'])->name('admin.games.edit');
    Route::put('/admin/games/{game}', [AdminGameController::class, 'update'])->name('admin.games.update');
    Route::delete('/admin/games/{game}', [AdminGameController::class, 'destroy'])->name('admin.games.destroy');

    Route::resource('admin/users', AdminUserController::class)->names('admin.users');

    // Outras rotas de admin aqui...
});

require __DIR__ . '/auth.php';
