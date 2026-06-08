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

        foreach ($data['palpites'] as $gameId => $palpiteData) {
            // Verifica se os campos foram preenchidos (ignora se estiver vazio)
            // Cria ou Atualiza o palpite
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
            return response()->json(['success' => 'Palpites salvos com sucesso!']);
        }

        return back()->with('success', 'Palpites salvos com sucesso!');
    }
}