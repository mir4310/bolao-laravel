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
        Schema::create('chute_de_ouro', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');
            
            // Atributos de escolhas (chute01, chute02, chute03 referenciando a tabela teams)
            $table->foreignId('chute01')->nullable()->constrained('teams')->onDelete('set null');
            $table->foreignId('chute02')->nullable()->constrained('teams')->onDelete('set null');
            $table->foreignId('chute03')->nullable()->constrained('teams')->onDelete('set null');
            
            // Atributos de pontos (pontos01, pontos02, pontos03 para cálculo posterior)
            $table->integer('pontos01')->nullable();
            $table->integer('pontos02')->nullable();
            $table->integer('pontos03')->nullable();

            $table->integer('total_pontos')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chute_de_ouro');
    }
};
