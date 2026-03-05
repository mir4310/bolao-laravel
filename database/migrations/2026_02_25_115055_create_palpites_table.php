<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('palpites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // ID do usuário
            $table->foreignId('game_id')->constrained()->onDelete('cascade'); // Qual o jogo
            $table->integer('home_team_goals')->nullable(); // Gols do time da casa
            $table->integer('away_team_goals')->nullable(); // Gols do visitante
            $table->integer('pontos')->nullable(); // Pontos conquistados (calculado posteriormente)
            $table->timestamps();

            // Garante que o usuário só tenha um palpite por jogo
            $table->unique(['user_id', 'game_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('palpites');
    }
};
