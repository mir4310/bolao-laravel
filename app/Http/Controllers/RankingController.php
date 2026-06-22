<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Palpite;
use App\Models\User;
use Illuminate\Http\Request;

class RankingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Busca apenas usuários ativos com a soma de seus pontos nos palpites
        $ranking = User::where('ativo', true)
            ->withSum('palpites', 'pontos')
            ->orderByDesc('palpites_sum_pontos')
            ->orderBy('name')
            ->get();

        // Pega as partidas em andamento para montar o vetor de classificação 
        $gamesEmAndamento = Game::with(['homeTeam', 'awayTeam'])->where('status', 1)->get();
        $partidasEmAndamento = [];
        foreach ($gamesEmAndamento as $game) {
            $palpites = Palpite::with(['user'])->where('game_id', $game->id)
                ->whereHas('user', fn($q) => $q->where('ativo', true))
                ->orderByDesc('pontos')->get();

            $gameDateTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $game->date . ' ' . $game->hour, 'America/Sao_Paulo');
            $isFuture = $gameDateTime->isFuture();
            $statusText = $isFuture ? 'Em breve' : 'Em Andamento';

            $partidasEmAndamento[] = (object)[
                'homeTeam' => $game->homeTeam->name,
                'awayTeam' => $game->awayTeam->name,
                'homeTeamBandeira' => $game->homeTeam->bandeira,
                'awayTeamBandeira' => $game->awayTeam->bandeira,
                'homeGoals' => $game->home_team_goals,
                'awayGoals' => $game->away_team_goals,
                'status' => $statusText,
                'isFuture' => $isFuture,
                'date' => $game->date,
                'hour' => $game->hour,
                'palpites' => $palpites
            ];
        }

        return view('ranking.index', compact('ranking', 'partidasEmAndamento'));
    }

    /**
     * Exibe os palpites de um usuário específico para partidas bloqueadas (status 1 ou 2).
     */
    public function userPalpites($id)
    {
        // Impede acesso à página de palpites de usuários inativos
        $user = User::where('ativo', true)->withSum('palpites', 'pontos')->findOrFail($id);

        // Busca todos os jogos em andamento (1) ou finalizados (2) e carrega o palpite do usuário
        $games = Game::with(['homeTeam', 'awayTeam', 'palpites' => function ($query) use ($user) {
            $query->where('user_id', $user->id);
        }])
        ->whereIn('status', [1, 2])
        ->orderBy('date')
        ->orderBy('hour')
        ->get();

        return view('ranking.user-palpites', compact('user', 'games'));
    }
}
