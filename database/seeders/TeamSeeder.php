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
            ['name' => 'Estados Unidos', 'slug' => 'us'],
            ['name' => 'México', 'slug' => 'mx'],
            ['name' => 'Canadá', 'slug' => 'ca'],

            // AMÉRICA DO SUL
            ['name' => 'Argentina', 'slug' => 'ar'],
            ['name' => 'Brasil', 'slug' => 'br'],
            ['name' => 'Uruguai', 'slug' => 'uy'],
            ['name' => 'Colômbia', 'slug' => 'co'],
            ['name' => 'Equador', 'slug' => 'ec'],
            ['name' => 'Paraguai', 'slug' => 'py'],
            ['name' => 'Chile', 'slug' => 'cl'],

            // EUROPA
            ['name' => 'França', 'slug' => 'fr'],
            ['name' => 'Inglaterra', 'slug' => 'gb'], // ISO para Reino Unido/Inglaterra no Flagpack
            ['name' => 'Espanha', 'slug' => 'es'],
            ['name' => 'Portugal', 'slug' => 'pt'],
            ['name' => 'Alemanha', 'slug' => 'de'],
            ['name' => 'Holanda', 'slug' => 'nl'],
            ['name' => 'Croácia', 'slug' => 'hr'],
            ['name' => 'Bélgica', 'slug' => 'be'],
            ['name' => 'Suíça', 'slug' => 'ch'],
            ['name' => 'Itália', 'slug' => 'it'],
            ['name' => 'Dinamarca', 'slug' => 'dk'],
            ['name' => 'Áustria', 'slug' => 'at'],

            // ÁSIA
            ['name' => 'Japão', 'slug' => 'jp'],
            ['name' => 'Coreia do Sul', 'slug' => 'kr'],
            ['name' => 'Irã', 'slug' => 'ir'],
            ['name' => 'Austrália', 'slug' => 'au'],
            ['name' => 'Catar', 'slug' => 'qa'],
            ['name' => 'Arábia Saudita', 'slug' => 'sa'],
            ['name' => 'Iraque', 'slug' => 'iq'],
            ['name' => 'Uzbequistão', 'slug' => 'uz'],

            // ÁFRICA
            ['name' => 'Marrocos', 'slug' => 'ma'],
            ['name' => 'Senegal', 'slug' => 'sn'],
            ['name' => 'Egito', 'slug' => 'eg'],
            ['name' => 'Nigéria', 'slug' => 'ng'],
            ['name' => 'Tunísia', 'slug' => 'tn'],
            ['name' => 'Argélia', 'slug' => 'dz'],
            ['name' => 'Camarões', 'slug' => 'cm'],
            ['name' => 'Costa do Marfim', 'slug' => 'ci'],
            ['name' => 'Mali', 'slug' => 'ml'],

            // CONCACAF (AMÉRICA DO NORTE/CENTRAL)
            ['name' => 'Panamá', 'slug' => 'pa'],
            ['name' => 'Costa Rica', 'slug' => 'cr'],
            ['name' => 'Jamaica', 'slug' => 'jm'],
            ['name' => 'Honduras', 'slug' => 'hn'],

            // OCEANIA
            ['name' => 'Nova Zelândia', 'slug' => 'nz'],

            // ... (mantenha as outras seleções que já colocamos)

            // VAGAS DE REPESCAGEM (A DEFINIR EM MARÇO/2026)
            ['name' => 'Repescagem Mundial 1', 'slug' => 'r1'],
            ['name' => 'Repescagem Mundial 2', 'slug' => 'r2'],
            ['name' => 'Repescagem Europeia 1', 'slug' => 'e1'],
            ['name' => 'Repescagem Europeia 2', 'slug' => 'e2'],
            
        ];

        foreach ($teams as $team) {
            Team::updateOrCreate(['slug' => $team['slug']], $team);
        }
    }
}
