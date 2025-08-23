<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('images')->insert([
            [
                'user_id' => 1,
                'file_name' => 'cardigan1.jpg',
            ],
            [
                'user_id' => 1,
                'file_name' => 'jacket1.jpg',
            ],
            [
                'user_id' => 1,
                'file_name' => 'jacket2.jpg',
            ],
            [
                'user_id' => 1,
                'file_name' => 'jogger-pants1.jpg',
            ],
            [
                'user_id' => 1,
                'file_name' => 'polo-shirt1.jpg',
            ],
            [
                'user_id' => 1,
                'file_name' => 'setup1.jpg',
            ],
            [
                'user_id' => 2,
                'file_name' => 'shirt1.jpg',
            ],
            [
                'user_id' => 2,
                'file_name' => 'shirt2.jpg',
            ],
            [
                'user_id' => 2,
                'file_name' => 'shirt3.jpg',
            ],
            // [
            //     'user_id' => 2,
            //     'file_name' => 'shirt4.jpg',
            // ],
            // [
            //     'user_id' => 2,
            //     'file_name' => 'shirt5.jpg',
            // ],
            [
                'user_id' => 2,
                'file_name' => 'slacks1.jpg',
            ],
            // [
            //     'user_id' => 1,
            //     'file_name' => 'slacks2.jpg',
            // ],
            // [
            //     'user_id' => 1,
            //     'file_name' => 'slacks3.jpg',
            // ],
            // [
            //     'user_id' => 1,
            //     'file_name' => 'slacks4.jpg',
            // ],
            // [
            //     'user_id' => 1,
            //     'file_name' => 'slacks5.jpg',
            // ],
            [
                'user_id' => 1,
                'file_name' => 'T-shirt1.jpg',
            ],
            // [
            //     'user_id' => 1,
            //     'file_name' => 'T-shirt2.jpg',
            // ],
            // [
            //     'user_id' => 1,
            //     'file_name' => 'T-shirt3.jpg',
            // ],
            // [
            //     'user_id' => 1,
            //     'file_name' => 'trench_coat1.jpg',
            // ],
        ]);
    }
}
