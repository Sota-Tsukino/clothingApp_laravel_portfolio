<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('seasons')->insert([
            [
                'name' => 'spring',
            ],
            [
                'name' => 'summer',
            ],
            [
                'name' => 'autumn',
            ],
            [
                'name' => 'winter',
            ],
        ]);
    }
}
