<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Palpite;
use App\Models\Team;
use Illuminate\Container\Attributes\DB;
use Illuminate\Http\Request;

class AdminGameController extends Controller
{
    public function index(Request $request)
    {
        // Busca todas as fases distintas cadastradas para preencher o filtro
        $fases = Game::select('fase')->distinct()->orderBy('fase')->pluck('fase');

        $query = Game::with(['homeTeam', 'awayTeam']);

        // Aplica o filtro se uma fase for selecionada
        if ($request->filled('fase')) {
            $query->where('fase', $request->fase);
        }

        // Filtro por Status (Padrão: 0 - Não Iniciado)
        if ($request->has('status')) {
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
        } else {
            $query->where('status', 0);
        }

        // Ordena por data e hora
        $games = $query->orderBy('date')->orderBy('hour')->get();

        return view('admin.games.index', compact('games', 'fases'));
    }

    public function create()
    {
        $teams = Team::orderBy('name')->get();
        return view('admin.games.create', compact('teams'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'home_team_id' => 'required|exists:teams,id',
            'away_team_id' => 'required|exists:teams,id',
            'group' => 'nullable|string|max:1',
            'date' => 'required|date',
            'hour' => 'required',
            'city' => 'required|string|max:255',
            'fase' => 'required|string|max:255',
            'pontos' => 'required|string|max:255',
            'status' => 'required|integer',
        ]);

        // Define valores padrão para campos opcionais na criação
        $data['email_sent'] = false;

        Game::create($data);

        return redirect()->route('admin.games.index')->with('success', 'Jogo criado com sucesso!');
    }

    public function edit(Game $game)
    {
        $teams = Team::orderBy('name')->get();
        return view('admin.games.edit', compact('game', 'teams'));
    }

    public function update(Request $request, Game $game)
    {
        $totalPontos = 0;
        $data = $request->validate([
            'home_team_id' => 'required|exists:teams,id',
            'away_team_id' => 'required|exists:teams,id',
            'group' => 'nullable|string|max:1',
            'home_team_goals' => 'nullable|integer',
            'away_team_goals' => 'nullable|integer',
            'status' => 'required|integer',
            'date' => 'required|date',
            'hour' => 'required',
            'city' => 'required|string|max:255',
            'fase' => 'required|integer|max:255',
            'pontos' => 'required|integer|max:255'
        ]);

        $game->update($data);

        // Rotina para ajustar os pontos de todos os palpites da referida partida
        $objPalpites = Palpite::where('game_id', $game->id)->get();

        foreach ($objPalpites as $palpite) {
            $totalPontos = 0;

            $erroPalpite = ($palpite->home_team_goals ?? null) === null || ($palpite->away_team_goals ?? null) === null;
            echo ("Home Team Gol : {$game->home_team_goals}<br>");
            echo ("Away Team Gol : {$game->away_team_goals}<br>");
            echo ("Palpite Home  : {$palpite->home_team_goals}<br>");
            echo ("Palpite Away  : {$palpite->away_team_goals}<br>");


            $nTotGolsPartida = $game->home_team_goals + $game->away_team_goals;
            $nTotGolsPalpite = $palpite->home_team_goals + $palpite->away_team_goals;
            if (!$erroPalpite) {
                if ($palpite->home_team_goals == $game->home_team_goals && $palpite->away_team_goals == $game->away_team_goals) {
                    //Placar Exato
                    $totalPontos = 6;
                } else {
                    //Acertou Empate ou o vencedor
                    if ($palpite->home_team_goals == $palpite->away_team_goals && $game->home_team_goals == $game->away_team_goals) {
                        $totalPontos = 3;
                    } else {
                        if ($palpite->home_team_goals > $palpite->away_team_goals && $game->home_team_goals > $game->away_team_goals) {
                            $totalPontos = 3;
                        } else
                        if ($palpite->home_team_goals < $palpite->away_team_goals && $game->home_team_goals < $game->away_team_goals) {
                            $totalPontos = 3;
                        }
                    }
                    //Atribui pontos de bonificação
                    if ($nTotGolsPalpite == $nTotGolsPartida) {
                        $totalPontos = $totalPontos + 1;
                    } elseif ($palpite->home_team_goals == $game->home_team_goals || $palpite->away_team_goals == $game->away_team_goals) {
                        $totalPontos = $totalPontos + 1;
                    }
                }
            }
            $palpite->pontos = $totalPontos;
            $palpite->save();
        }

        //return redirect()->route('admin.games.index')->with('success', 'Jogo atualizado com sucesso!');
        return redirect()->route('admin.games.edit', $game->id)->with('success', 'Jogo atualizado com sucesso!');
    }

    public function destroy(Game $game)
    {
        $game->delete();

        return redirect()->route('admin.games.index')->with('success', 'Jogo excluído com sucesso!');
    }
}
