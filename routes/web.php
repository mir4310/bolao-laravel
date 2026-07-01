<?php

use App\Http\Controllers\ChuteDeOuroController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminGameController;
use App\Http\Controllers\AdminSettingController;
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

Route::get('/avatar/{id}.svg', function ($id) {
    $path = "avatars/{$id}.svg";
    if (\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
        return response()->file(\Illuminate\Support\Facades\Storage::disk('public')->path($path), [
            'Content-Type' => 'image/svg+xml'
        ]);
    }

    $user = \App\Models\User::find($id);
    if ($user && $user->getRawOriginal('avatar')) {
        return redirect($user->getRawOriginal('avatar'));
    }

    return response()->file(public_path('img/no-avatar.png'));
})->name('user.avatar');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [PalpiteController::class, 'index'])->name('dashboard');
    Route::post('/palpites', [PalpiteController::class, 'store'])->name('palpites.store');
    Route::post('/chute-de-ouro', [ChuteDeOuroController::class, 'store'])->name('chute-de-ouro.store');
    Route::get('/partida/{id}/apostas', [PalpiteController::class, 'partidaApostas'])->name('partida.apostas');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/ranking', [RankingController::class, 'index'])->name('ranking.index');
    Route::get('/ranking/user/{id}', [RankingController::class, 'userPalpites'])->name('ranking.user-palpites');
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
    Route::post('/admin/users/sync-avatars', [AdminUserController::class, 'syncAvatars'])->name('admin.users.sync-avatars');
    Route::post('/admin/users/{user}/reset-password', [AdminUserController::class, 'resetPassword'])->name('admin.users.reset-password');

    // Configurações Globais (Chute de Ouro)
    Route::get('/admin/settings', [AdminSettingController::class, 'index'])->name('admin.settings.index');
    Route::post('/admin/settings', [AdminSettingController::class, 'store'])->name('admin.settings.store');
    Route::post('/admin/settings/process', [AdminSettingController::class, 'processarChute'])->name('admin.settings.process');
});

require __DIR__ . '/auth.php';
