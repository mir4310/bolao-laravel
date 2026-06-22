<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Campo ativo: true = usuário pode logar, false = bloqueado
            $table->boolean('ativo')->default(true)->after('avatar');
        });

        // Garante que todos os usuários já existentes ficam como ativo = true
        DB::table('users')->update(['ativo' => true]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('ativo');
        });
    }
};
