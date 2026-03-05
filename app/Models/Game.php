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
}