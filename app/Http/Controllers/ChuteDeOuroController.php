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
        $data = $request->validate([
            'chute01' => 'nullable|exists:teams,id',
            'chute02' => 'nullable|exists:teams,id',
            'chute03' => 'nullable|exists:teams,id',
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
