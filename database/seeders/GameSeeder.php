<?php

namespace Database\Seeders;

use App\Models\Game;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    public function run(): void
    {
        $games = [
            // GRUPO A (EUA, Repescagem 1, Panamá, Uzbequistão)
            ['group' => 'A', 'home' => 1, 'away' => 45, 'date' => '2026-06-12', 'hour' => '23:00', 'city' => 'Los Angeles'],
            ['group' => 'A', 'home' => 40, 'away' => 30, 'date' => '2026-06-13', 'hour' => '16:00', 'city' => 'Houston'],
            ['group' => 'A', 'home' => 1, 'away' => 40, 'date' => '2026-06-19', 'hour' => '22:00', 'city' => 'Seattle'],
            ['group' => 'A', 'home' => 30, 'away' => 45, 'date' => '2026-06-20', 'hour' => '19:00', 'city' => 'San Francisco'],
            ['group' => 'A', 'home' => 30, 'away' => 1, 'date' => '2026-06-25', 'hour' => '23:00', 'city' => 'Los Angeles'],
            ['group' => 'A', 'home' => 45, 'away' => 40, 'date' => '2026-06-25', 'hour' => '23:00', 'city' => 'Seattle'],

            // GRUPO B (México, Jamaica, Inglaterra, Catar)
            ['group' => 'B', 'home' => 2, 'away' => 42, 'date' => '2026-06-11', 'hour' => '22:30', 'city' => 'Cidade do México'],
            ['group' => 'B', 'home' => 12, 'away' => 27, 'date' => '2026-06-13', 'hour' => '13:00', 'city' => 'New Jersey'],
            ['group' => 'B', 'home' => 2, 'away' => 12, 'date' => '2026-06-18', 'hour' => '23:00', 'city' => 'Guadalajara'],
            ['group' => 'B', 'home' => 27, 'away' => 42, 'date' => '2026-06-19', 'hour' => '16:00', 'city' => 'Dallas'],
            ['group' => 'B', 'home' => 27, 'away' => 2, 'date' => '2026-06-24', 'hour' => '23:00', 'city' => 'Cidade do México'],
            ['group' => 'B', 'home' => 42, 'away' => 12, 'date' => '2026-06-24', 'hour' => '23:00', 'city' => 'Monterrey'],

            // GRUPO C (Canadá, Honduras, Espanha, Japão)
            ['group' => 'C', 'home' => 3, 'away' => 43, 'date' => '2026-06-12', 'hour' => '22:00', 'city' => 'Toronto'],
            ['group' => 'C', 'home' => 13, 'away' => 23, 'date' => '2026-06-13', 'hour' => '21:00', 'city' => 'Boston'],
            ['group' => 'C', 'home' => 3, 'away' => 13, 'date' => '2026-06-18', 'hour' => '20:00', 'city' => 'Vancouver'],
            ['group' => 'C', 'home' => 23, 'away' => 43, 'date' => '2026-06-19', 'hour' => '13:00', 'city' => 'Philadelphia'],
            ['group' => 'C', 'home' => 23, 'away' => 3, 'date' => '2026-06-24', 'hour' => '20:00', 'city' => 'Vancouver'],
            ['group' => 'C', 'home' => 43, 'away' => 13, 'date' => '2026-06-24', 'hour' => '20:00', 'city' => 'Toronto'],

            // GRUPO D (Argentina, Marrocos, Holanda, Arábia Saudita)
            ['group' => 'D', 'home' => 4, 'away' => 31, 'date' => '2026-06-14', 'hour' => '21:00', 'city' => 'Houston'],
            ['group' => 'D', 'home' => 16, 'away' => 28, 'date' => '2026-06-14', 'hour' => '16:00', 'city' => 'Dallas'],
            ['group' => 'D', 'home' => 4, 'away' => 16, 'date' => '2026-06-20', 'hour' => '21:00', 'city' => 'New Jersey'],
            ['group' => 'D', 'home' => 31, 'away' => 28, 'date' => '2026-06-20', 'hour' => '13:00', 'city' => 'Philadelphia'],
            ['group' => 'D', 'home' => 28, 'away' => 4, 'date' => '2026-06-26', 'hour' => '16:00', 'city' => 'Miami'],
            ['group' => 'D', 'home' => 31, 'away' => 16, 'date' => '2026-06-26', 'hour' => '16:00', 'city' => 'Atlanta'],

            // GRUPO E (Brasil, Senegal, Alemanha, Croácia)
            ['group' => 'E', 'home' => 5, 'away' => 32, 'date' => '2026-06-14', 'hour' => '19:00', 'city' => 'Miami'],
            ['group' => 'E', 'home' => 17, 'away' => 15, 'date' => '2026-06-15', 'hour' => '21:00', 'city' => 'Atlanta'],
            ['group' => 'E', 'home' => 5, 'away' => 17, 'date' => '2026-06-20', 'hour' => '16:00', 'city' => 'Kansas City'],
            ['group' => 'E', 'home' => 15, 'away' => 32, 'date' => '2026-06-21', 'hour' => '13:00', 'city' => 'Philadelphia'],
            ['group' => 'E', 'home' => 15, 'away' => 5, 'date' => '2026-06-26', 'hour' => '21:00', 'city' => 'Dallas'],
            ['group' => 'E', 'home' => 32, 'away' => 17, 'date' => '2026-06-26', 'hour' => '21:00', 'city' => 'Houston'],

            // GRUPO F (França, Coreia do Sul, Dinamarca, Egito)
            ['group' => 'F', 'home' => 11, 'away' => 24, 'date' => '2026-06-15', 'hour' => '16:00', 'city' => 'New Jersey'],
            ['group' => 'F', 'home' => 21, 'away' => 33, 'date' => '2026-06-15', 'hour' => '13:00', 'city' => 'Boston'],
            ['group' => 'F', 'home' => 11, 'away' => 21, 'date' => '2026-06-21', 'hour' => '19:00', 'city' => 'Toronto'],
            ['group' => 'F', 'home' => 24, 'away' => 33, 'date' => '2026-06-21', 'hour' => '16:00', 'city' => 'Washington'],
            ['group' => 'F', 'home' => 33, 'away' => 11, 'date' => '2026-06-27', 'hour' => '16:00', 'city' => 'New Jersey'],
            ['group' => 'F', 'home' => 24, 'away' => 21, 'date' => '2026-06-27', 'hour' => '16:00', 'city' => 'Philadelphia'],

            // GRUPO G (Portugal, Uruguai, Austrália, Nigéria)
            ['group' => 'G', 'home' => 14, 'away' => 6, 'date' => '2026-06-16', 'hour' => '21:00', 'city' => 'Dallas'],
            ['group' => 'G', 'home' => 26, 'away' => 34, 'date' => '2026-06-16', 'hour' => '16:00', 'city' => 'Houston'],
            ['group' => 'G', 'home' => 14, 'away' => 26, 'date' => '2026-06-22', 'hour' => '19:00', 'city' => 'San Francisco'],
            ['group' => 'G', 'home' => 6, 'away' => 34, 'date' => '2026-06-22', 'hour' => '13:00', 'city' => 'Seattle'],
            ['group' => 'G', 'home' => 34, 'away' => 14, 'date' => '2026-06-27', 'hour' => '22:00', 'city' => 'Dallas'],
            ['group' => 'G', 'home' => 6, 'away' => 26, 'date' => '2026-06-27', 'hour' => '22:00', 'city' => 'Houston'],

            // GRUPO H (Itália, Colômbia, Suíça, Argélia)
            ['group' => 'H', 'home' => 20, 'away' => 7, 'date' => '2026-06-16', 'hour' => '13:00', 'city' => 'Miami'],
            ['group' => 'H', 'home' => 19, 'away' => 36, 'date' => '2026-06-17', 'hour' => '16:00', 'city' => 'New York'],
            ['group' => 'H', 'home' => 20, 'away' => 19, 'date' => '2026-06-22', 'hour' => '21:00', 'city' => 'Atlanta'],
            ['group' => 'H', 'home' => 7, 'away' => 36, 'date' => '2026-06-23', 'hour' => '19:00', 'city' => 'Miami'],
            ['group' => 'H', 'home' => 36, 'away' => 20, 'date' => '2026-06-28', 'hour' => '13:00', 'city' => 'New York'],
            ['group' => 'H', 'home' => 7, 'away' => 19, 'date' => '2026-06-28', 'hour' => '13:00', 'city' => 'Atlanta'],

            // GRUPO I (Bélgica, Equador, Tunísia, Rep. Mundial 2)
            ['group' => 'I', 'home' => 18, 'away' => 8, 'date' => '2026-06-17', 'hour' => '19:00', 'city' => 'Seattle'],
            ['group' => 'I', 'home' => 35, 'away' => 46, 'date' => '2026-06-17', 'hour' => '22:00', 'city' => 'San Francisco'],
            ['group' => 'I', 'home' => 18, 'away' => 35, 'date' => '2026-06-23', 'hour' => '16:00', 'city' => 'Vancouver'],
            ['group' => 'I', 'home' => 8, 'away' => 46, 'date' => '2026-06-23', 'hour' => '22:00', 'city' => 'Los Angeles'],
            ['group' => 'I', 'home' => 46, 'away' => 18, 'date' => '2026-06-28', 'hour' => '16:00', 'city' => 'Seattle'],
            ['group' => 'I', 'home' => 8, 'away' => 35, 'date' => '2026-06-28', 'hour' => '16:00', 'city' => 'San Francisco'],

            // GRUPO J (Paraguai, Irã, Camarões, Rep. Europeia 1)
            ['group' => 'J', 'home' => 9, 'away' => 25, 'date' => '2026-06-18', 'hour' => '13:00', 'city' => 'Kansas City'],
            ['group' => 'J', 'home' => 37, 'away' => 47, 'date' => '2026-06-18', 'hour' => '16:00', 'city' => 'Atlanta'],
            ['group' => 'J', 'home' => 9, 'away' => 37, 'date' => '2026-06-24', 'hour' => '13:00', 'city' => 'Philadelphia'],
            ['group' => 'J', 'home' => 25, 'away' => 47, 'date' => '2026-06-24', 'hour' => '16:00', 'city' => 'Boston'],
            ['group' => 'J', 'home' => 47, 'away' => 9, 'date' => '2026-06-29', 'hour' => '19:00', 'city' => 'Toronto'],
            ['group' => 'J', 'home' => 25, 'away' => 37, 'date' => '2026-06-29', 'hour' => '19:00', 'city' => 'Boston'],

            // GRUPO K (Chile, Áustria, Costa do Marfim, Rep. Europeia 2)
            ['group' => 'K', 'home' => 10, 'away' => 22, 'date' => '2026-06-18', 'hour' => '19:00', 'city' => 'Houston'],
            ['group' => 'K', 'home' => 38, 'away' => 48, 'date' => '2026-06-19', 'hour' => '21:00', 'city' => 'Dallas'],
            ['group' => 'K', 'home' => 10, 'away' => 38, 'date' => '2026-06-24', 'hour' => '19:00', 'city' => 'Miami'],
            ['group' => 'K', 'home' => 22, 'away' => 48, 'date' => '2026-06-25', 'hour' => '16:00', 'city' => 'Washington'],
            ['group' => 'K', 'home' => 48, 'away' => 10, 'date' => '2026-06-30', 'hour' => '21:00', 'city' => 'New York'],
            ['group' => 'K', 'home' => 22, 'away' => 38, 'date' => '2026-06-30', 'hour' => '21:00', 'city' => 'Atlanta'],

            // GRUPO L (Nova Zelândia, Iraque, Mali, Costa Rica)
            ['group' => 'L', 'home' => 44, 'away' => 29, 'date' => '2026-06-19', 'hour' => '13:00', 'city' => 'Philadelphia'],
            ['group' => 'L', 'home' => 39, 'away' => 41, 'date' => '2026-06-20', 'hour' => '22:00', 'city' => 'Vancouver'],
            ['group' => 'L', 'home' => 44, 'away' => 39, 'date' => '2026-06-25', 'hour' => '13:00', 'city' => 'Boston'],
            ['group' => 'L', 'home' => 29, 'away' => 41, 'date' => '2026-06-25', 'hour' => '20:00', 'city' => 'Mexico City'],
            ['group' => 'L', 'home' => 41, 'away' => 44, 'date' => '2026-06-30', 'hour' => '16:00', 'city' => 'Toronto'],
            ['group' => 'L', 'home' => 29, 'away' => 39, 'date' => '2026-06-30', 'hour' => '16:00', 'city' => 'Philadelphia'],
        ];

        foreach ($games as $game) {
            Game::create([
                'home_team_id' => $game['home'],
                'away_team_id' => $game['away'],
                'group'        => $game['group'],
                'date'         => $game['date'],
                'hour'         => $game['hour'],
                'city'         => $game['city'],
                'status'       => 0,
                'fase'         => 1,
                'pontos'       => 1,
            ]);
        }
    }
}