<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Game;

class FetchGameResults extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-game-results';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Busca e atualiza os placares das partidas em andamento a partir da API externa';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Busca partidas com status "Em andamento" (1) que tenham ID de integração configurado
        $games = Game::where('status', 1)
            ->whereNotNull('api_id')
            ->where('api_id', '!=', '')
            ->get();

        if ($games->isEmpty()) {
            $this->info('Nenhuma partida em andamento com ID de integração configurado.');
            return 0;
        }

        foreach ($games as $index => $game) {
            if ($index > 0) {
                $this->info('Aguardando 10 segundos antes de realizar a próxima consulta à API...');
                sleep(10);
            }

            $url = "https://worldcup26.ir/get/game/{$game->api_id}";
            $this->info("Buscando resultados para o jogo ID {$game->id} (API ID: {$game->api_id}) em: {$url}");

            try {
                $response = Http::timeout(10)->get($url);

                if ($response->successful()) {
                    $data = $response->json();

                    if (isset($data['game'])) {
                        $apiGame = $data['game'];

                        // Extrai gols se disponíveis na resposta da API
                        $homeScore = isset($apiGame['home_score']) ? (int) $apiGame['home_score'] : null;
                        $awayScore = isset($apiGame['away_score']) ? (int) $apiGame['away_score'] : null;

                        if ($homeScore !== null && $awayScore !== null) {
                            $game->home_team_goals = $homeScore;
                            $game->away_team_goals = $awayScore;
                            $this->info("Placar atualizado na API: {$game->homeTeam->name} {$homeScore} x {$awayScore} {$game->awayTeam->name}");
                        }

                        // Se o campo finished for TRUE (case-insensitive ou boolean), atualiza status para Finalizado (2)
                        $finished = isset($apiGame['finished']) && (strtoupper((string) $apiGame['finished']) === 'TRUE' || $apiGame['finished'] === true);
                        if ($finished) {
                            $game->status = 2; // Finalizado
                            $this->info("Partida finalizada na API externa.");
                        }

                        $game->save();

                        // Recalcula os pontos dos palpites dos usuários para este jogo
                        $game->recalculatePalpitesPoints();
                        $this->info("Pontos dos palpites recalculados com sucesso para a partida ID {$game->id}.");
                    } else {
                        $this->error("Retorno da API inválido ou estrutura incomum para o jogo ID {$game->id}.");
                    }
                } else {
                    $this->error("Erro de HTTP {$response->status()} ao acessar a API para o jogo ID {$game->id}.");
                }
            } catch (\Exception $e) {
                $this->error("Exceção ao chamar a API para o jogo ID {$game->id}: " . $e->getMessage());
            }
        }

        return 0;
    }
}
