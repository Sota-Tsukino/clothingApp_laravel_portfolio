<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cities')->insert([
            [
                'prefecture_id' => '1',
                'name' => '千代田区',
                'latitude' => null,
                'longitude' => null,
            ],
            [
                'prefecture_id' => '1',
                'name' => '中央区',
                'latitude' => null,
                'longitude' => null,
            ],
            [
                'prefecture_id' => '1',
                'name' => '港区',
                'latitude' => null,
                'longitude' => null,
            ],
            [
                'prefecture_id' => '2',
                'name' => '横浜市',
                'latitude' => null,
                'longitude' => null,
            ],
            [
                'prefecture_id' => '2',
                'name' => '川崎市',
                'latitude' => null,
                'longitude' => null,
            ],
            [
                'prefecture_id' => '2',
                'name' => '小田原市',
                'latitude' => null,
                'longitude' => null,
            ],
        ]);
    }
}
