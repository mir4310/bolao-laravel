<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // 1. Criar o seu usuário Administrador
        User::updateOrCreate(
            ['email' => 'barduco@gmail.com'], // Evita duplicar se rodar o seeder de novo
            [
                'name' => 'Junior Barduco',
                'telefone' => '(14) 99658-1771',
                'quem_indicou' => 'Admin',
                'password' => '$2y$12$u6dX/g6JUz3B./gY4nT5XOWzl5uv1ND2JUHgEvcscYumDvo4K4h9m',
                'email_verified_at' => now(),
                'role' => 'administrador',
                'data_pagamento' => now(),
                'valor' => 20.00,
                'avatar' => 'https://avataaars.io/?avatarStyle=Transparent&topType=ShortHairShortFlat&accessoriesType=Wayfarers&hairColor=BrownDark&facialHairType=Blank&clotheType=GraphicShirt&clotheColor=Heather&eyeType=Wink&eyebrowType=RaisedExcitedNatural&mouthType=Tongue&skinColor=Light'
            ]
        );


        User::updateOrCreate(
            ['email' => 'arthur@bentivenha.com.br'], // Evita duplicar se rodar o seeder de novo
            [
                'name' => 'Arthur Bentivenha',
                'telefone' => '(14) 98222-2222',
                'quem_indicou' => 'Junior',
                'password' => '$2y$12$u6dX/g6JUz3B./gY4nT5XOWzl5uv1ND2JUHgEvcscYumDvo4K4h9m',
                'email_verified_at' => now(),
                'role' => 'administrador'
            ]
        );

        User::updateOrCreate(
            ['email' => 'karina.temibrela@gmail.com'], // Evita duplicar se rodar o seeder de novo
            [
                'name' => 'Karina Martins Barduco',
                'telefone' => '(14) 99777-8200',
                'quem_indicou' => 'Junior',
                'password' => '$2y$12$frLXKgcVf4QNcOpZ7qDTYO8TzpAooBMXCV22b.VIuTbjur7AV4T.2',
                'email_verified_at' => now(),
                'role' => 'usuario',
                'data_pagamento' => now(),
                'valor' => 20.00,
                'avatar' => 'https://avataaars.io/?avatarStyle=Transparent&topType=LongHairStraight&accessoriesType=Wayfarers&hairColor=Blonde&facialHairType=Blank&clotheType=ShirtCrewNeck&clotheColor=PastelGreen&eyeType=Happy&eyebrowType=DefaultNatural&mouthType=Twinkle&skinColor=Light'
            ]
        );

        User::updateOrCreate(
            ['email' => 'heliokushima@gmail.com'], // Evita duplicar se rodar o seeder de novo
            [
                'name' => 'Hélio Kushima',
                'telefone' => '(14) 99686-2481',
                'quem_indicou' => 'Junior',
                'password' => '$2y$12$UgJReENp0e2CfpHvm3OlbOOwvQUsp7A02/vtkcdU.fv.zBHRLh.0C',
                'email_verified_at' => now(),
                'role' => 'usuario',
                'avatar' => 'https://avataaars.io/?avatarStyle=Transparent&topType=ShortHairShortWaved&accessoriesType=Prescription02&hairColor=Black&facialHairType=Blank&clotheType=ShirtCrewNeck&clotheColor=Black&eyeType=Happy&eyebrowType=AngryNatural&mouthType=Sad&skinColor=Light'
            ]
        );

        // 2. Criar 200 usuários de teste
        /*
        $faker = \Faker\Factory::create('pt_BR');

        for ($i = 1; $i <= 200; $i++) {
            User::updateOrCreate(
                ['email' => "teste{$i}@example.com"], // garante que não repita
                [
                    'name' => $faker->name,
                    'telefone' => $faker->cellphoneNumber,
                    'quem_indicou' => $faker->firstName,
                    'password' => Hash::make('!Test1234#'), // mesma senha para todos
                    'email_verified_at' => now(),
                    'role' => 'usuario'
                ]
            );
        }
        */

        // Povoa as tabelas iniciais
        $this->call([
            TeamSeeder::class,
            GameSeeder::class,
        ]);
    }
}
