<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use App\Models\Team;
use App\Models\ChuteDeOuro;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    public function index()
    {
        $teams = Team::orderBy('name')->get();
        
        $settings = [
            'chute_campea' => AppSetting::where('key', 'chute_campea')->value('value'),
            'chute_vice' => AppSetting::where('key', 'chute_vice')->value('value'),
            'chute_artilheiros' => AppSetting::where('key', 'chute_artilheiros')->value('value') ?? [],
        ];

        return view('admin.settings.index', compact('teams', 'settings'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'chute_campea' => 'nullable|exists:teams,id',
            'chute_vice' => 'nullable|exists:teams,id',
            'chute_artilheiros' => 'nullable|array',
            'chute_artilheiros.*' => 'exists:teams,id',
        ]);

        AppSetting::updateOrCreate(['key' => 'chute_campea'], ['value' => $data['chute_campea'] ?? null]);
        AppSetting::updateOrCreate(['key' => 'chute_vice'], ['value' => $data['chute_vice'] ?? null]);
        AppSetting::updateOrCreate(['key' => 'chute_artilheiros'], ['value' => $data['chute_artilheiros'] ?? []]);

        return back()->with('success', 'Configurações atualizadas com sucesso!');
    }

    public function processarChute()
    {
        $campea = AppSetting::where('key', 'chute_campea')->value('value');
        $vice = AppSetting::where('key', 'chute_vice')->value('value');
        $artilheiros = AppSetting::where('key', 'chute_artilheiros')->value('value') ?? [];

        if (!$campea || !$vice || empty($artilheiros)) {
            return back()->with('error', 'Por favor, defina a Campeã, Vice-campeã e Artilharia antes de processar.');
        }

        $chutes = ChuteDeOuro::all();
        foreach ($chutes as $chute) {
            $pontos = 0;
            if ($chute->chute01 == $campea) $pontos += 30;
            if ($chute->chute02 == $vice) $pontos += 30;
            if (in_array($chute->chute03, $artilheiros)) $pontos += 30;

            $chute->total_pontos = $pontos;
            $chute->save();
        }

        return back()->with('success', 'Pontuação do Chute de Ouro processada para todos os apostadores!');
    }
}
