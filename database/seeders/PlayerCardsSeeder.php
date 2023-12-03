<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlayerCardsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $player = DB::table('players')
            ->select(['id'])
            ->orderBy('id', 'desc')
            ->limit(1)
            ->first()
        ;

        $cards = DB::table('cards')
            ->select('id')
            ->get()
        ;

        foreach ($cards as $card) {
            DB::table('players_cards')->insert([
                'player_id' => $player->id,
                'card_id' => $card->id
            ]);
        }
    }
}
