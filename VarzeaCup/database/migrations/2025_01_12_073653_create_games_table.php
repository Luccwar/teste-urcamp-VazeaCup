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
            $table->id(); // ID (Auto Incremento)
            $table->foreignId('team1_id')->constrained('teams'); // Time 1 (Referência à tabela teams)
            $table->foreignId('team2_id')->constrained('teams'); // Time 2 (Referência à tabela teams)
            $table->integer('winner')->nullable(); // 0: Empate, 1: 1º Time Venceu, 2: 2º Time Venceu
            $table->dateTime('date_time'); // Data e Hora
            $table->integer('round');
            $table->timestamps(); // Created_at, Updated_at
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
