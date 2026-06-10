<?php

namespace App\Console\Commands;

use App\Models\Game;
use Carbon\Carbon;
use Illuminate\Console\Command;

class LockStartingGames extends Command
{
    /**
     * Nome e assinatura do comando.
     */
    protected $signature = 'games:lock-starting';

    /**
     * Descrição exibida no php artisan list.
     */
    protected $description = 'Bloqueia (status=1) partidas que iniciam em até 60 minutos.';

    public function handle(): int
    {
        $now = Carbon::now(); // UTC — comparamos convertendo o horário do jogo para UTC

        // Janela: jogos que começam entre agora e agora + 60 min (horário de Brasília → UTC)
        $windowStart = $now->copy();
        $windowEnd   = $now->copy()->addMinutes(60);

        // Busca jogos ainda não bloqueados (status = 0) e sem gols registrados
        $games = Game::where('status', 0)
            ->whereNull('home_team_goals')
            ->whereNull('away_team_goals')
            ->get()
            ->filter(function (Game $game) use ($windowStart, $windowEnd) {
                $gameStart = Carbon::createFromFormat(
                    'Y-m-d H:i:s',
                    $game->date . ' ' . $game->hour,
                    'America/Sao_Paulo'
                )->setTimezone('UTC');

                return $gameStart->between($windowStart, $windowEnd)
                    || $gameStart->lessThanOrEqualTo($windowStart); // já deveria ter iniciado
            });

        if ($games->isEmpty()) {
            $this->info('[' . $now->toDateTimeString() . '] Nenhuma partida para bloquear.');
            return self::SUCCESS;
        }

        foreach ($games as $game) {
            $game->update([
                'status'          => 1,
                'home_team_goals' => 0,
                'away_team_goals' => 0,
            ]);
            $this->info(
                sprintf(
                    '[%s] Jogo #%d bloqueado e placar zerado: %s %s',
                    $now->toDateTimeString(),
                    $game->id,
                    $game->date,
                    $game->hour
                )
            );
        }

        return self::SUCCESS;
    }
}
