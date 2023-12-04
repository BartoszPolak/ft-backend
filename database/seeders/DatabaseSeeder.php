<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(OpponentsSeeder::class);

        $this->call(UserSeeder::class);
        $this->call(PlayerSeeder::class);

        $this->call(CardsSeeder::class);

        $this->call(PlayerCardsSeeder::class);
    }
}
