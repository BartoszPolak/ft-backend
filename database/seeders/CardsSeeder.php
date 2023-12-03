<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CardsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cards = config('game.cards');

        foreach ($cards as $card) {
            DB::table('cards')->insert([
                'name' => $card['name'],
                'image' => $card['image'],
                'power' => $card['power'],
            ]);
        }
    }
}
