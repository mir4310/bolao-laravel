<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Palpite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ApostasPartidaMail;

class SiteController extends Controller
{
    public function regulamento()
    {
        $participantes = User::whereNotNull('data_pagamento')->count();
        $valorBolao = 30;

        return view('regulamento', compact('participantes', 'valorBolao'));
    }

    public function jogoApostas(Request $request, $id)
    {
        $idPartida = $id;

        // Busca o jogo com os times
        $game = Game::with(['homeTeam', 'awayTeam'])->findOrFail($idPartida);

        // Busca todos os usuários que pagaram, ordenados por nome
        $users = User::whereNotNull('data_pagamento')
            ->orderBy('name')
            ->get();

        // Busca os palpites existentes para este jogo
        $palpitesExistentes = Palpite::where('game_id', $idPartida)
            ->get()
            ->keyBy('user_id'); // Indexa pelo ID do usuário para facilitar a busca

        // Monta a lista final combinando Usuários + Palpites
        $listaPalpites = $users->map(function ($user) use ($palpitesExistentes) {
            // Se o usuário tem palpite, usa ele. Se não, cria um objeto vazio/novo.
            $palpite = $palpitesExistentes->get($user->id) ?? new Palpite();

            // Associa o usuário ao palpite (manual, pois o objeto vazio não tem relação carregada)
            $palpite->setRelation('user', $user);

            return $palpite;
        });

        // Monta o objeto que a view espera
        $partida = (object) [
            'homeTeam' => $game->homeTeam->name,
            'awayTeam' => $game->awayTeam->name,
            'homeTeamBandeira' => $game->homeTeam->bandeira,
            'awayTeamBandeira' => $game->awayTeam->bandeira,
            'date' => \Carbon\Carbon::parse($game->date)->format('d/m/Y'),
            'hour' => \Carbon\Carbon::parse($game->hour)->format('H:i'),
            'city' => $game->city,
            'fase' => $game->fase,
            'pontos' => $game->pontos,
            'palpites' => $listaPalpites,
        ];

        // A classe Mailable 'ApostasPartidaMail' já está configurada para usar a view correta.
        Mail::to('barduco@gmail.com')->send(new ApostasPartidaMail($partida));

        return 'Partida processada...';
    }
}
