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
        Schema::create('players_duels', function (Blueprint $table) {
            $table->id();
            $table->integer('player_id');
            $table->integer('opponent_id');
            $table->integer('round')->unsigned()->default(1);
            $table->integer('player_points')->unsigned()->default(0);
            $table->integer('opponent_points')->unsigned()->default(0);
            $table->integer('won')->unsigned()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players_duels');
    }
};
