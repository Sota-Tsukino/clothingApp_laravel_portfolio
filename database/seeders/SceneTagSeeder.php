<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SceneTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('scene_tags')->insert([
            [
                'name' => 'vacation',
            ],
            [
                'name' => 'office',
            ],
            [
                'name' => 'event',
            ],
            [
                'name' => 'school',
            ],
            [
                'name' => 'party',
            ],
            [
                'name' => 'drive',
            ],
            [
                'name' => 'trip',
            ],
            [
                'name' => 'drinking_party',
            ],
            [
                'name' => 'lunch',
            ],
            [
                'name' => 'outing',
            ],
            [
                'name' => 'shopping',
            ],
        ]);
    }
}
