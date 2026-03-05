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
        Schema::create('games', function (Blueprint $table) {
            $table->id();

            // Relacionamento com as seleções
            $table->string('group', 1)->nullable();
            $table->integer('fase')->nullable();
            $table->integer('pontos')->nullable();
            ; // Armazena 'A', 'B', 'C', etc.
            $table->foreignId('home_team_id')->constrained('teams');
            $table->foreignId('away_team_id')->constrained('teams');

            // Dados do Jogo
            $table->date('date');
            $table->time('hour');
            $table->string('city');

            // Placar
            $table->integer('home_team_goals')->nullable();
            $table->integer('away_team_goals')->nullable();

            // Status: 0-Aguardando, 1-Iniciado, 2-Finalizado
            $table->tinyInteger('status')->default(0);
            $table->boolean('email_sent')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
