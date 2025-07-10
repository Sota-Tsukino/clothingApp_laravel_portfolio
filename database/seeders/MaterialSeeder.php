<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('materials')->insert([
            [
                'name' => 'cotton',
            ],
            [
                'name' => 'linen',
            ],
            [
                'name' => 'silk',
            ],
            [
                'name' => 'wool',
            ],
            [
                'name' => 'cashmere',
            ],
            [
                'name' => 'alpaca',
            ],
            [
                'name' => 'angora',
            ],
            [
                'name' => 'camel',
            ],
            [
                'name' => 'polyester',
            ],
            [
                'name' => 'nylon',
            ],
            [
                'name' => 'acrylic',
            ],
            [
                'name' => 'polyurethane',
            ],
            [
                'name' => 'rayon',
            ],
            [
                'name' => 'polynosic',
            ],
            [
                'name' => 'cupra',
            ],
            [
                'name' => 'acetate',
            ],
            [
                'name' => 'triacetate',
            ],
            [
                'name' => 'promix',
            ],
            [
                'name' => 'modal', //モダール
            ],
            [
                'name' => 'lyocell', //リヨセル
            ],
            [
                'name' => 'tencel', //テンセル
            ],
        ]);
    }
}
