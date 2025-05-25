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
        //備考 category_id: 1=tops 2=bottoms 3=setup 4=outer 5=other
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
                'category_id' => '1',
                'name' => 'polo-shirt',
            ],
            [
                'category_id' => '1',
                'name' => 'sweatshirt',
            ],
            [
                'category_id' => '1',
                'name' => 'hoodie',//パーカー
            ],
            [
                'category_id' => '1',
                'name' => 'pullover-sweater',//プルオーバー
            ],
            [
                'category_id' => '1',
                'name' => 'knitwear',//ニットセーター
            ],
            [
                'category_id' => '1',
                'name' => 'undershirt',//インナー
            ],
            [
                'category_id' => '1',
                'name' => 'other',
            ],
            [
                'category_id' => '2',
                'name' => 'shorts',//ショートパンツ
            ],
            [
                'category_id' => '2',
                'name' => 'skinny-jeans',
            ],
            [
                'category_id' => '2',
                'name' => 'jeans',//デニムパンツ
            ],
            [
                'category_id' => '2',
                'name' => 'tapered-pants',//テーパードパンツ
            ],
            [
                'category_id' => '2',
                'name' => 'jogger-pants',
            ],
            [
                'category_id' => '2',
                'name' => 'wide-leg-pants',
            ],
            [
                'category_id' => '2',
                'name' => 'knit-trousers',//ニットパンツ
            ],
            [
                'category_id' => '2',
                'name' => 'slacks',
            ],
            [
                'category_id' => '2',
                'name' => 'chino-pants',
            ],
            [
                'category_id' => '2',
                'name' => 'cargo-pants',
            ],
            [
                'category_id' => '2',
                'name' => 'sweat-pants',
            ],
            [
                'category_id' => '2',
                'name' => 'cropped-pants',
            ],
            [
                'category_id' => '3',
                'name' => 'co-ord',//セットアップ
            ],
            [
                'category_id' => '3',
                'name' => 'suits',//
            ],
            [
                'category_id' => '3',
                'name' => 'other',
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
                'category_id' => '4',
                'name' => 'denim-jacket',//デニムジャケット
            ],
            [
                'category_id' => '4',
                'name' => 'tailored-jacket',//テーラードジャケット
            ],
            [
                'category_id' => '4',
                'name' => 'down-jacket',//ダウンジャケット
            ],
            [
                'category_id' => '4',
                'name' => 'fleece',//フリース
            ],
            [
                'category_id' => '4',
                'name' => 'boa-jacket',//ボアジャケット
            ],
            [
                'category_id' => '4',
                'name' => 'blouson',//ブルゾン
            ],
            [
                'category_id' => '4',
                'name' => 'stadium-jacket',//スタジャン
            ],
            [
                'category_id' => '4',
                'name' => 'mountain-parka',//マウンテンパーカー
            ],
            [
                'category_id' => '4',
                'name' => 'coat',
            ],
            [
                'category_id' => '4',
                'name' => 'trench-coat',
            ],
            [
                'category_id' => '4',
                'name' => 'mods-coat',
            ],
            [
                'category_id' => '4',
                'name' => 'chester-coat',
            ],
            [
                'category_id' => '4',
                'name' => 'balmacaan-coat',//ステンカラーコート
            ],
            [
                'category_id' => '4',
                'name' => 'duffle-coat',//ダッフルコート
            ],
            [
                'category_id' => '4',
                'name' => 'pea-coat',//Pコート
            ],
            [
                'category_id' => '4',
                'name' => 'down-coat',
            ],
            [
                'category_id' => '4',
                'name' => 'other',
            ],
            [
                'category_id' => '5',//その他
                'name' => 'room-wear',//ルームウェア
            ],
            [
                'category_id' => '5',
                'name' => 'under-wear',
            ],
            [
                'category_id' => '5',
                'name' => 'kimono_and_yukata',
            ],
            [
                'category_id' => '5',
                'name' => 'sports-wear',
            ],
            [
                'category_id' => '5',
                'name' => 'other',
            ],
        ]);
    }
}
