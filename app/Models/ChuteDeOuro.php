<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChuteDeOuro extends Model
{
    use HasFactory;

    protected $table = 'chute_de_ouro';

    protected $fillable = [
        'user_id',
        'chute01',
        'chute02',
        'chute03',
        'pontos01',
        'pontos02',
        'pontos03',
        'total_pontos',
    ];

    /**
     * Get the user that owns this chute de ouro guess.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the team for selection 1 (chute01).
     */
    public function team01(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'chute01');
    }

    /**
     * Get the team for selection 2 (chute02).
     */
    public function team02(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'chute02');
    }

    /**
     * Get the team for selection 3 (chute03).
     */
    public function team03(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'chute03');
    }
}
