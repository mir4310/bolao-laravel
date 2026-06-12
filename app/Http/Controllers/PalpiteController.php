<?php

namespace App\Http\Controllers;

use App\Models\ChuteDeOuro;
use App\Models\Game;
use App\Models\Palpite;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PalpiteController extends Controller
{
    public function index()
    {
        // Busca todos os jogos ordenados por data
        // Carrega os times e o palpite do usuário logado (se existir)
        $games = Game::with(['homeTeam', 'awayTeam', 'userPalpite'])
            ->orderBy('fase')
            ->orderBy('date')
            ->orderBy('hour')
            ->orderBy('group')
            ->get();

        // Seleções disponíveis para o Chute de Ouro
        $teams = Team::orderBy('name')->get();

        // Chute de Ouro do usuário logado (se já tiver registrado)
        $chuteDeOuro = ChuteDeOuro::where('user_id', Auth::id())->first();

        return view('dashboard', compact('games', 'teams', 'chuteDeOuro'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'palpites' => 'required|array',
            'palpites.*.home_goals' => 'nullable|integer|min:0',
            'palpites.*.away_goals' => 'nullable|integer|min:0',
        ]);

        $jogosIgnorados = 0; // conta jogos bloqueados por prazo

        foreach ($data['palpites'] as $gameId => $palpiteData) {
            // Busca o jogo para verificar o horário de início
            $game = Game::find($gameId);

            // Bloqueia se o jogo começa em menos de 60 minutos ou já iniciou
            // O horário do jogo está salvo no fuso de Brasília (America/Sao_Paulo)
            $gameDateTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $game->date . ' ' . $game->hour, 'America/Sao_Paulo');
            if (now()->diffInMinutes($gameDateTime, false) < 60) {
                $jogosIgnorados++;
                continue; // pula, não salva
            }

            // Bloqueia se o status ou email_sent indicam partida iniciada/encerrada
            if ($game->status != 0 || $game->email_sent != 0) {
                $jogosIgnorados++;
                continue;
            }

            Palpite::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'game_id' => $gameId,
                ],
                [
                    'home_team_goals' => $palpiteData['home_goals'],
                    'away_team_goals' => $palpiteData['away_goals'],
                ]
            );
        }

        // Se a requisição for AJAX, retorna uma resposta JSON
        if ($request->expectsJson()) {
            return response()->json([
                'success'         => 'Palpites salvos com sucesso!',
                'jogos_ignorados' => $jogosIgnorados, // frontend usa para recarregar se > 0
            ]);
        }

        return back()->with('success', 'Palpites salvos com sucesso!');
    }

    public function partidaApostas($id)
    {
        // Busca o jogo com os times
        $game = Game::with(['homeTeam', 'awayTeam'])->findOrFail($id);

        // Só exibe se a partida estiver em andamento (1) ou finalizada (2)
        if ($game->status == 0) {
            abort(403, 'As apostas para esta partida ainda não estão disponíveis para visualização.');
        }

        // Busca todos os usuários
        $users = \App\Models\User::orderBy('name')->get();

        // Busca os palpites existentes para este jogo
        $palpitesExistentes = Palpite::where('game_id', $game->id)
            ->get()
            ->keyBy('user_id');

        // Combina usuários e palpites
        $listaPalpites = $users->map(function ($user) use ($palpitesExistentes) {
            $palpite = $palpitesExistentes->get($user->id);
            if (!$palpite) {
                $palpite = new Palpite([
                    'user_id' => $user->id,
                    'game_id' => null,
                    'home_team_goals' => null,
                    'away_team_goals' => null,
                    'pontos' => 0,
                ]);
            }
            $palpite->setRelation('user', $user);
            return $palpite;
        })->sortByDesc('pontos')->values();

        // Monta o objeto que a view espera
        $partida = (object) [
            'homeTeam' => $game->homeTeam->name,
            'awayTeam' => $game->awayTeam->name,
            'homeTeamBandeira' => $game->homeTeam->bandeira,
            'awayTeamBandeira' => $game->awayTeam->bandeira,
            'homeGoals' => $game->home_team_goals,
            'awayGoals' => $game->away_team_goals,
            'date' => \Carbon\Carbon::parse($game->date)->format('d/m/Y'),
            'hour' => \Carbon\Carbon::parse($game->hour)->format('H:i'),
            'city' => $game->city,
            'fase' => $game->fase,
            'pontos' => $game->pontos,
            'status' => $game->status,
            'palpites' => $listaPalpites,
        ];

        return view('games.jogosapostas2', compact('partida'));
    }
}