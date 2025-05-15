<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tags')->insert([
            [
                'name' => 'casual',
            ],
            [
                'name' => 'formal',
            ],
            [
                'name' => 'business',
            ],
            [
                'name' => 'fashonable',
            ],
            [
                'name' => 'hot-day',
            ],
            [
                'name' => 'cold-day',
            ],
        ]);
    }
}
