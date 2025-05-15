<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sub_categories')->insert([
            [
                'category_id' => '1',
                'name' => 'tanktop',
            ],
            [
                'category_id' => '1',
                'name' => 'T-shirt',
            ],
            [
                'category_id' => '1',
                'name' => 'shirt',
            ],
            [
                'category_id' => '2',
                'name' => 'short-pants',
            ],
            [
                'category_id' => '2',
                'name' => 'half-pants',
            ],
            [
                'category_id' => '2',
                'name' => 'skinny-pants',
            ],
            [
                'category_id' => '3',
                'name' => 'setup',
            ],
            [
                'category_id' => '3',
                'name' => 'suits',
            ],
            [
                'category_id' => '3',
                'name' => 'others',
            ],
            [
                'category_id' => '4',// アウター
                'name' => 'cardigan',//カーディガン
            ],
            [
                'category_id' => '4',
                'name' => 'vest',//ベスト
            ],
            [
                'category_id' => '4',
                'name' => 'jacket',//ジャケット
            ],
            [
                'category_id' => '5',//その他
                'name' => 'room-wear',//ルームウェア
            ],
            [
                'category_id' => '5',//その他
                'name' => 'under-wear',
            ],
            [
                'category_id' => '5',//その他
                'name' => 'kimono_yukata',
            ],
        ]);
    }
}
