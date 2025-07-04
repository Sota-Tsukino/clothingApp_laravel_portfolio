<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('items')->insert([
            [
                'user_id' => 1,
                'image_id' => '1',
                'category_id' => '4',
                'sub_category_id' => '29',
                'brand_id' => '1',
                'status' => 'owned',
                // 'is_public' => 0,
                'is_item_suggest' => 0,
                'created_at' => '2025/01/01',
            ],
            [
                'user_id' => 1,
                'image_id' => '2',
                'category_id' => '4',
                'sub_category_id' => '32',
                'brand_id' => '1',
                'status' => 'owned',
                // 'is_public' => 0,
                'is_item_suggest' => 0,
                'created_at' => '2025/01/01',
            ],
            [
                'user_id' => 1,
                'image_id' => '3',
                'category_id' => '4',
                'sub_category_id' => '32',
                'brand_id' => '1',
                'status' => 'owned',
                // 'is_public' => 0,
                'is_item_suggest' => 0,
                'created_at' => '2025/01/01',
            ],
            [
                'user_id' => 1,
                'image_id' => '4',
                'category_id' => '2',
                'sub_category_id' => '18',
                'brand_id' => '1',
                'status' => 'owned',
                // 'is_public' => 0,
                'is_item_suggest' => 0,
                'created_at' => '2025/01/01',
            ],
            [
                'user_id' => 1,
                'image_id' => '5',
                'category_id' => '1',
                'sub_category_id' => '4',
                'brand_id' => '1',
                'status' => 'owned',
                // 'is_public' => 0,
                'is_item_suggest' => 0,
                'created_at' => '2025/01/01',
            ],
            [
                'user_id' => 1,
                'image_id' => '6',
                'category_id' => '3',
                'sub_category_id' => '26',
                'brand_id' => '1',
                'status' => 'owned',
                // 'is_public' => 0,
                'is_item_suggest' => 0,
                'created_at' => '2025/01/01',
            ],
            [
                'user_id' => 2,
                'image_id' => '7',
                'category_id' => '4',
                'sub_category_id' => '29',
                'brand_id' => '1',
                'status' => 'owned',
                // 'is_public' => 0,
                'is_item_suggest' => 0,
                'created_at' => '2025/01/01',
            ],
            [
                'user_id' => 2,
                'image_id' => '8',
                'category_id' => '4',
                'sub_category_id' => '32',
                'brand_id' => '1',
                'status' => 'owned',
                // 'is_public' => 0,
                'is_item_suggest' => 0,
                'created_at' => '2025/01/01',
            ],
            [
                'user_id' => 2,
                'image_id' => '9',
                'category_id' => '4',
                'sub_category_id' => '32',
                'brand_id' => '1',
                'status' => 'owned',
                // 'is_public' => 0,
                'is_item_suggest' => 0,
                'created_at' => '2025/01/01',
            ],
            [
                'user_id' => 2,
                'image_id' => '10',
                'category_id' => '2',
                'sub_category_id' => '18',
                'brand_id' => '1',
                'status' => 'owned',
                // 'is_public' => 0,
                'is_item_suggest' => 0,
                'created_at' => '2025/01/01',
            ],
            [
                'user_id' => 2,
                'image_id' => '11',
                'category_id' => '1',
                'sub_category_id' => '4',
                'brand_id' => '1',
                'status' => 'owned',
                // 'is_public' => 0,
                'is_item_suggest' => 0,
                'created_at' => '2025/01/01',
            ],
            [
                'user_id' => 2,
                'image_id' => '12',
                'category_id' => '3',
                'sub_category_id' => '26',
                'brand_id' => '1',
                'status' => 'owned',
                // 'is_public' => 0,
                'is_item_suggest' => 0,
                'created_at' => '2025/01/01',
            ],
        ]);
    }
}
