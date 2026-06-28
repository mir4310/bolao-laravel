<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'api_id',
        'group',
        'home_team_id',
        'away_team_id',
        'date',
        'hour',
        'city',
        'fase',
        'pontos',
        'home_team_goals',
        'away_team_goals',
        'status',
        'email_sent',
    ];

    public function homeTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    public function awayTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }

    /**
     * Retorna o palpite do usuário logado para este jogo.
     */
    public function userPalpite(): HasOne
    {
        return $this->hasOne(Palpite::class)->where('user_id', Auth::id());
    }

    /**
     * Retorna todos os palpites deste jogo.
     */
    public function palpites()
    {
        return $this->hasMany(Palpite::class);
    }

    /**
     * Recalcula os pontos de todos os palpites deste jogo.
     */
    public function recalculatePalpitesPoints()
    {
        if ($this->status >= 1) {
            $peso = ($this->pontos !== null && $this->pontos > 0) ? (float) $this->pontos : 1;
            $objPalpites = $this->palpites;

            foreach ($objPalpites as $palpite) {
                $totalPontos = 0;

                $erroPalpite = ($palpite->home_team_goals ?? null) === null || ($palpite->away_team_goals ?? null) === null;

                $nTotGolsPartida = $this->home_team_goals + $this->away_team_goals;
                $nTotGolsPalpite = $palpite->home_team_goals + $palpite->away_team_goals;
                if (!$erroPalpite) {
                    if ($palpite->home_team_goals == $this->home_team_goals && $palpite->away_team_goals == $this->away_team_goals) {
                        //Placar Exato
                        $totalPontos = 6;
                    } else {
                        //Acertou Empate ou o vencedor
                        if ($palpite->home_team_goals == $palpite->away_team_goals && $this->home_team_goals == $this->away_team_goals) {
                            $totalPontos = 3;
                        } else {
                            if ($palpite->home_team_goals > $palpite->away_team_goals && $this->home_team_goals > $this->away_team_goals) {
                                $totalPontos = 3;
                            } else
                            if ($palpite->home_team_goals < $palpite->away_team_goals && $this->home_team_goals < $this->away_team_goals) {
                                $totalPontos = 3;
                            }
                        }
                        //Atribui pontos de bonificação
                        if ($nTotGolsPalpite == $nTotGolsPartida) {
                            $totalPontos = $totalPontos + 1;
                        } elseif ($palpite->home_team_goals == $this->home_team_goals || $palpite->away_team_goals == $this->away_team_goals) {
                            $totalPontos = $totalPontos + 1;
                        }
                    }
                }
                $palpite->pontos = $totalPontos * $peso;
                $palpite->save();
            }
        }
    }
}