<?php

namespace App\Http\Controllers;

use App\Models\ChuteDeOuro;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChuteDeOuroController extends Controller
{
    /**
     * Salva (cria ou atualiza) o Chute de Ouro do usuário logado.
     */
    public function store(Request $request)
    {
        // Bloqueia quando qualquer partida da fase 3 (Oitavas) já iniciou
        $bloqueado = \App\Models\Game::where('fase', 3)->where('status', '>=', 1)->exists();

        if ($bloqueado) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'As apostas do Chute de Ouro estão encerradas.'], 403);
            }
            return back()->withErrors(['chute' => 'As apostas do Chute de Ouro estão encerradas.']);
        }

        $data = $request->validate([
            'chute01' => 'nullable|exists:teams,id',
            'chute02' => 'nullable|exists:teams,id|different:chute01',
            'chute03' => 'nullable|exists:teams,id',
        ], [
            'chute02.different' => 'A seleção vice-campeã não pode ser a mesma que a campeã.'
        ]);

        ChuteDeOuro::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'chute01' => $data['chute01'] ?? null,
                'chute02' => $data['chute02'] ?? null,
                'chute03' => $data['chute03'] ?? null,
            ]
        );

        if ($request->expectsJson()) {
            return response()->json(['success' => 'Chute de Ouro salvo com sucesso!']);
        }

        return back()->with('success', 'Chute de Ouro salvo com sucesso!');
    }
}
