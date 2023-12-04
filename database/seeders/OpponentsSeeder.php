<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OpponentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $levels = config('game.player_levels');
        foreach ($levels as $level => $maxPoints) {
            DB::table('players')->insert([
                'id' => $level,
                'user_id' => null,
                'level' => $level,
                'name' => fake('en_US')->name(),
            ]);
        }
    }
}
