<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = DB::table('users')
            ->select('id', 'name')
            ->orderBy('id', 'desc')
            ->limit(1)
            ->first()
        ;

        DB::table('players')->insert([
            'user_id' => $user->id,
            'name' => $user->name,
        ]);
    }
}
