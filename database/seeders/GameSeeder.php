<?php

namespace Database\Seeders;

use App\Models\Game;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    public function run(): void
    {
        $games = [
            // GRUPO A (México [2], África do Sul [39], Coreia do Sul [25], República Tcheca [22])
            ['group' => 'A', 'home' => 2, 'away' => 39, 'date' => '2026-06-11', 'hour' => '16:00', 'city' => 'Cidade do México'],
            ['group' => 'A', 'home' => 25, 'away' => 22, 'date' => '2026-06-11', 'hour' => '23:00', 'city' => 'Guadalajara'],
            ['group' => 'A', 'home' => 22, 'away' => 39, 'date' => '2026-06-18', 'hour' => '13:00', 'city' => 'Atlanta'],
            ['group' => 'A', 'home' => 2, 'away' => 25, 'date' => '2026-06-18', 'hour' => '22:00', 'city' => 'Guadalajara'],
            ['group' => 'A', 'home' => 22, 'away' => 2, 'date' => '2026-06-24', 'hour' => '22:00', 'city' => 'Cidade do México'],
            ['group' => 'A', 'home' => 39, 'away' => 25, 'date' => '2026-06-24', 'hour' => '22:00', 'city' => 'Monterrey'],

            // GRUPO B (Canadá [3], Bósnia [47], Catar [28], Suíça [18])
            ['group' => 'B', 'home' => 3, 'away' => 47, 'date' => '2026-06-12', 'hour' => '16:00', 'city' => 'Toronto'],
            ['group' => 'B', 'home' => 28, 'away' => 18, 'date' => '2026-06-13', 'hour' => '16:00', 'city' => 'São Francisco'],
            ['group' => 'B', 'home' => 18, 'away' => 47, 'date' => '2026-06-18', 'hour' => '16:00', 'city' => 'Los Angeles'],
            ['group' => 'B', 'home' => 3, 'away' => 28, 'date' => '2026-06-18', 'hour' => '19:00', 'city' => 'Vancouver'],
            ['group' => 'B', 'home' => 18, 'away' => 3, 'date' => '2026-06-24', 'hour' => '16:00', 'city' => 'Vancouver'],
            ['group' => 'B', 'home' => 47, 'away' => 28, 'date' => '2026-06-24', 'hour' => '16:00', 'city' => 'Seattle'],

            // GRUPO C (Brasil [5], Marrocos [33], Haiti [43], Escócia [48])
            ['group' => 'C', 'home' => 5, 'away' => 33, 'date' => '2026-06-13', 'hour' => '19:00', 'city' => 'Nova York'],
            ['group' => 'C', 'home' => 43, 'away' => 48, 'date' => '2026-06-13', 'hour' => '22:00', 'city' => 'Boston'],
            ['group' => 'C', 'home' => 48, 'away' => 33, 'date' => '2026-06-19', 'hour' => '19:00', 'city' => 'Boston'],
            ['group' => 'C', 'home' => 5, 'away' => 43, 'date' => '2026-06-19', 'hour' => '21:30', 'city' => 'Filadélfia'],
            ['group' => 'C', 'home' => 48, 'away' => 5, 'date' => '2026-06-24', 'hour' => '19:00', 'city' => 'Miami'],
            ['group' => 'C', 'home' => 33, 'away' => 43, 'date' => '2026-06-24', 'hour' => '19:00', 'city' => 'Atlanta'],

            // GRUPO D (Estados Unidos [1], Paraguai [9], Austrália [27], Turquia [23])
            ['group' => 'D', 'home' => 1, 'away' => 9, 'date' => '2026-06-12', 'hour' => '22:00', 'city' => 'Los Angeles'],
            ['group' => 'D', 'home' => 27, 'away' => 23, 'date' => '2026-06-13', 'hour' => '01:00', 'city' => 'Vancouver'],
            ['group' => 'D', 'home' => 23, 'away' => 9, 'date' => '2026-06-19', 'hour' => '01:00', 'city' => 'São Francisco'],
            ['group' => 'D', 'home' => 1, 'away' => 27, 'date' => '2026-06-19', 'hour' => '16:00', 'city' => 'Seattle'],
            ['group' => 'D', 'home' => 23, 'away' => 1, 'date' => '2026-06-25', 'hour' => '23:00', 'city' => 'Los Angeles'],
            ['group' => 'D', 'home' => 9, 'away' => 27, 'date' => '2026-06-25', 'hour' => '23:00', 'city' => 'São Francisco'],

            // GRUPO E (Alemanha [14], Curaçau [44], Costa do Marfim [38], Equador [8])
            ['group' => 'E', 'home' => 14, 'away' => 44, 'date' => '2026-06-14', 'hour' => '14:00', 'city' => 'Houston'],
            ['group' => 'E', 'home' => 38, 'away' => 8, 'date' => '2026-06-14', 'hour' => '20:00', 'city' => 'Filadélfia'],
            ['group' => 'E', 'home' => 14, 'away' => 38, 'date' => '2026-06-20', 'hour' => '17:00', 'city' => 'Toronto'],
            ['group' => 'E', 'home' => 8, 'away' => 44, 'date' => '2026-06-20', 'hour' => '21:00', 'city' => 'Kansas City'],
            ['group' => 'E', 'home' => 44, 'away' => 38, 'date' => '2026-06-25', 'hour' => '17:00', 'city' => 'Filadélfia'],
            ['group' => 'E', 'home' => 8, 'away' => 14, 'date' => '2026-06-25', 'hour' => '17:00', 'city' => 'Nova York'],

            // GRUPO F (Holanda [15], Japão [24], Suécia [20], Tunísia [36])
            ['group' => 'F', 'home' => 15, 'away' => 24, 'date' => '2026-06-14', 'hour' => '17:00', 'city' => 'Dallas'],
            ['group' => 'F', 'home' => 20, 'away' => 36, 'date' => '2026-06-14', 'hour' => '23:00', 'city' => 'Monterrey'],
            ['group' => 'F', 'home' => 36, 'away' => 24, 'date' => '2026-06-20', 'hour' => '01:00', 'city' => 'Monterrey'],
            ['group' => 'F', 'home' => 15, 'away' => 20, 'date' => '2026-06-20', 'hour' => '14:00', 'city' => 'Houston'],
            ['group' => 'F', 'home' => 24, 'away' => 20, 'date' => '2026-06-25', 'hour' => '20:00', 'city' => 'Dallas'],
            ['group' => 'F', 'home' => 36, 'away' => 15, 'date' => '2026-06-25', 'hour' => '20:00', 'city' => 'Kansas City'],

            // GRUPO G (Bélgica [17], Egito [35], Irã [26], Nova Zelândia [45])
            ['group' => 'G', 'home' => 17, 'away' => 35, 'date' => '2026-06-15', 'hour' => '16:00', 'city' => 'Seattle'],
            ['group' => 'G', 'home' => 26, 'away' => 45, 'date' => '2026-06-15', 'hour' => '22:00', 'city' => 'Los Angeles'],
            ['group' => 'G', 'home' => 17, 'away' => 26, 'date' => '2026-06-21', 'hour' => '16:00', 'city' => 'Los Angeles'],
            ['group' => 'G', 'home' => 45, 'away' => 35, 'date' => '2026-06-21', 'hour' => '22:00', 'city' => 'Vancouver'],
            ['group' => 'G', 'home' => 35, 'away' => 26, 'date' => '2026-06-27', 'hour' => '00:00', 'city' => 'Seattle'],
            ['group' => 'G', 'home' => 45, 'away' => 17, 'date' => '2026-06-27', 'hour' => '00:00', 'city' => 'Vancouver'],

            // GRUPO H (Espanha [12], Cabo Verde [46], Arábia Saudita [29], Uruguai [6])
            ['group' => 'H', 'home' => 12, 'away' => 46, 'date' => '2026-06-15', 'hour' => '13:00', 'city' => 'Atlanta'],
            ['group' => 'H', 'home' => 29, 'away' => 6, 'date' => '2026-06-15', 'hour' => '19:00', 'city' => 'Miami'],
            ['group' => 'H', 'home' => 12, 'away' => 29, 'date' => '2026-06-21', 'hour' => '13:00', 'city' => 'Atlanta'],
            ['group' => 'H', 'home' => 6, 'away' => 46, 'date' => '2026-06-21', 'hour' => '19:00', 'city' => 'Miami'],
            ['group' => 'H', 'home' => 46, 'away' => 29, 'date' => '2026-06-26', 'hour' => '21:00', 'city' => 'Houston'],
            ['group' => 'H', 'home' => 6, 'away' => 12, 'date' => '2026-06-26', 'hour' => '21:00', 'city' => 'Guadalajara'],

            // GRUPO I (França [10], Senegal [34], Iraque [30], Noruega [21])
            ['group' => 'I', 'home' => 10, 'away' => 34, 'date' => '2026-06-16', 'hour' => '16:00', 'city' => 'Nova York'],
            ['group' => 'I', 'home' => 30, 'away' => 21, 'date' => '2026-06-16', 'hour' => '19:00', 'city' => 'Boston'],
            ['group' => 'I', 'home' => 10, 'away' => 30, 'date' => '2026-06-22', 'hour' => '18:00', 'city' => 'Filadélfia'],
            ['group' => 'I', 'home' => 21, 'away' => 34, 'date' => '2026-06-22', 'hour' => '21:00', 'city' => 'Nova York'],
            ['group' => 'I', 'home' => 34, 'away' => 30, 'date' => '2026-06-26', 'hour' => '18:00', 'city' => 'Boston'],
            ['group' => 'I', 'home' => 21, 'away' => 10, 'date' => '2026-06-26', 'hour' => '18:00', 'city' => 'Filadélfia'],

            // GRUPO J (Áustria [19], Jordânia [32], Argentina [4], Argélia [37])
            ['group' => 'J', 'home' => 19, 'away' => 32, 'date' => '2026-06-16', 'hour' => '01:00', 'city' => 'São Francisco'],
            ['group' => 'J', 'home' => 4, 'away' => 37, 'date' => '2026-06-16', 'hour' => '22:00', 'city' => 'Kansas City'],
            ['group' => 'J', 'home' => 32, 'away' => 37, 'date' => '2026-06-22', 'hour' => '00:00', 'city' => 'São Francisco'],
            ['group' => 'J', 'home' => 4, 'away' => 19, 'date' => '2026-06-22', 'hour' => '14:00', 'city' => 'Dallas'],
            ['group' => 'J', 'home' => 37, 'away' => 19, 'date' => '2026-06-27', 'hour' => '23:00', 'city' => 'Kansas City'],
            ['group' => 'J', 'home' => 32, 'away' => 4, 'date' => '2026-06-27', 'hour' => '23:00', 'city' => 'Dallas'],

            // GRUPO K (Portugal [13], RD Congo [41], Uzbequistão [31], Colômbia [7])
            ['group' => 'K', 'home' => 13, 'away' => 41, 'date' => '2026-06-17', 'hour' => '14:00', 'city' => 'Houston'],
            ['group' => 'K', 'home' => 31, 'away' => 7, 'date' => '2026-06-17', 'hour' => '23:00', 'city' => 'Cidade do México'],
            ['group' => 'K', 'home' => 13, 'away' => 31, 'date' => '2026-06-23', 'hour' => '14:00', 'city' => 'Houston'],
            ['group' => 'K', 'home' => 7, 'away' => 41, 'date' => '2026-06-23', 'hour' => '23:00', 'city' => 'Guadalajara'],
            ['group' => 'K', 'home' => 7, 'away' => 13, 'date' => '2026-06-27', 'hour' => '20:30', 'city' => 'Miami'],
            ['group' => 'K', 'home' => 41, 'away' => 31, 'date' => '2026-06-27', 'hour' => '20:30', 'city' => 'Atlanta'],

            // GRUPO L (Inglaterra [11], Croácia [16], Gana [40], Panamá [42])
            ['group' => 'L', 'home' => 11, 'away' => 16, 'date' => '2026-06-17', 'hour' => '17:00', 'city' => 'Dallas'],
            ['group' => 'L', 'home' => 40, 'away' => 42, 'date' => '2026-06-17', 'hour' => '20:00', 'city' => 'Toronto'],
            ['group' => 'L', 'home' => 11, 'away' => 40, 'date' => '2026-06-23', 'hour' => '17:00', 'city' => 'Boston'],
            ['group' => 'L', 'home' => 42, 'away' => 16, 'date' => '2026-06-23', 'hour' => '20:00', 'city' => 'Toronto'],
            ['group' => 'L', 'home' => 42, 'away' => 11, 'date' => '2026-06-27', 'hour' => '18:00', 'city' => 'Nova York'],
            ['group' => 'L', 'home' => 16, 'away' => 40, 'date' => '2026-06-27', 'hour' => '18:00', 'city' => 'Filadélfia'],
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