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
        Schema::table('players_duels', function (Blueprint $table) {
            $table->index(['player_id', 'finished']);
            $table->index(['opponent_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('players_duels', function (Blueprint $table) {
            $table->dropIndex(['player_id', 'finished']);
            $table->dropIndex(['opponent_id']);
        });
    }
};
