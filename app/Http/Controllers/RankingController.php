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
        // Busca todos os usuários com a soma de seus pontos nos palpites
        $ranking = User::withSum('palpites', 'pontos')
            ->orderByDesc('palpites_sum_pontos')
            ->orderBy('name')
            ->get();

        // Pega as partidas em andamento para montar o vetor de classificação 
        $gamesEmAndamento = Game::with(['homeTeam', 'awayTeam'])->where('status', 1)->get();
        $partidasEmAndamento = [];
        foreach ($gamesEmAndamento as $game) {
            $palpites = Palpite::with(['user'])->where('game_id', $game->id)->orderByDesc('pontos')->get();

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
}
