<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    public function run(): void
    {
        $teams = [
            // ANFITRIÕES
            ['name' => 'Estados Unidos', 'slug' => 'us'], // ID 1
            ['name' => 'México', 'slug' => 'mx'],         // ID 2
            ['name' => 'Canadá', 'slug' => 'ca'],         // ID 3

            // AMÉRICA DO SUL (CONMEBOL)
            ['name' => 'Argentina', 'slug' => 'ar'],      // ID 4
            ['name' => 'Brasil', 'slug' => 'br'],         // ID 5
            ['name' => 'Uruguai', 'slug' => 'uy'],        // ID 6
            ['name' => 'Colômbia', 'slug' => 'co'],       // ID 7
            ['name' => 'Equador', 'slug' => 'ec'],        // ID 8
            ['name' => 'Paraguai', 'slug' => 'py'],       // ID 9

            // EUROPA (UEFA)
            ['name' => 'França', 'slug' => 'fr'],         // ID 10
            ['name' => 'Inglaterra', 'slug' => 'gb'],     // ID 11
            ['name' => 'Espanha', 'slug' => 'es'],        // ID 12
            ['name' => 'Portugal', 'slug' => 'pt'],       // ID 13
            ['name' => 'Alemanha', 'slug' => 'de'],       // ID 14
            ['name' => 'Holanda', 'slug' => 'nl'],        // ID 15
            ['name' => 'Croácia', 'slug' => 'hr'],        // ID 16
            ['name' => 'Bélgica', 'slug' => 'be'],        // ID 17
            ['name' => 'Suíça', 'slug' => 'ch'],          // ID 18
            ['name' => 'Áustria', 'slug' => 'at'],        // ID 19
            ['name' => 'Suécia', 'slug' => 'se'],         // ID 20
            ['name' => 'Noruega', 'slug' => 'no'],        // ID 21
            ['name' => 'República Tcheca', 'slug' => 'cz'], // ID 22
            ['name' => 'Turquia', 'slug' => 'tr'],        // ID 23

            // ÁSIA (AFC)
            ['name' => 'Japão', 'slug' => 'jp'],          // ID 24
            ['name' => 'Coreia do Sul', 'slug' => 'kr'],  // ID 25
            ['name' => 'Irã', 'slug' => 'ir'],            // ID 26
            ['name' => 'Austrália', 'slug' => 'au'],      // ID 27
            ['name' => 'Catar', 'slug' => 'qa'],          // ID 28
            ['name' => 'Arábia Saudita', 'slug' => 'sa'], // ID 29
            ['name' => 'Iraque', 'slug' => 'iq'],         // ID 30
            ['name' => 'Uzbequistão', 'slug' => 'uz'],    // ID 31
            ['name' => 'Jordânia', 'slug' => 'jo'],       // ID 32

            // ÁFRICA (CAF)
            ['name' => 'Marrocos', 'slug' => 'ma'],       // ID 33
            ['name' => 'Senegal', 'slug' => 'sn'],        // ID 34
            ['name' => 'Egito', 'slug' => 'eg'],          // ID 35
            ['name' => 'Tunísia', 'slug' => 'tn'],        // ID 36
            ['name' => 'Argélia', 'slug' => 'dz'],        // ID 37
            ['name' => 'Costa do Marfim', 'slug' => 'ci'], // ID 38
            ['name' => 'África do Sul', 'slug' => 'za'],  // ID 39
            ['name' => 'Gana', 'slug' => 'gh'],           // ID 40
            ['name' => 'RD Congo', 'slug' => 'cd'],       // ID 41

            // CONCACAF (AMÉRICA DO NORTE, CENTRAL E CARIBE)
            ['name' => 'Panamá', 'slug' => 'pa'],         // ID 42
            ['name' => 'Haiti', 'slug' => 'ht'],          // ID 43
            ['name' => 'Curaçau', 'slug' => 'cw'],        // ID 44

            // OCEANIA (OFC)
            ['name' => 'Nova Zelândia', 'slug' => 'nz'],  // ID 45
            ['name' => 'Cabo Verde', 'slug' => 'cv'],     // ID 46 (Movido para ID regular único)
            ['name' => 'Bósnia', 'slug' => 'ba'],         // ID 47 (Vaga preenchida do Grupo B)
            ['name' => 'Escócia', 'slug' => 'gb-sct'],    // ID 48 (Vaga preenchida do Grupo C)
        ];

        foreach ($teams as $team) {
            Team::updateOrCreate(['slug' => $team['slug']], $team);
        }
    }
}