<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Imports\CitiesImport;
use Maatwebsite\Excel\Facades\Excel;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cities')->insert([
            // [
            //     'prefecture_id' => '1',
            //     'name' => '千代田区',
            //     'latitude' => null,
            //     'longitude' => null,
            // ],
            // [
            //     'prefecture_id' => '1',
            //     'name' => '中央区',
            //     'latitude' => null,
            //     'longitude' => null,
            // ],
            // [
            //     'prefecture_id' => '1',
            //     'name' => '港区',
            //     'latitude' => null,
            //     'longitude' => null,
            // ],
            // [
            //     'prefecture_id' => '1',
            //     'name' => '新宿区',
            //     'latitude' => null,
            //     'longitude' => null,
            // ],
            // [
            //     'prefecture_id' => '1',
            //     'name' => '文京区',
            //     'latitude' => null,
            //     'longitude' => null,
            // ],
            // [
            //     'prefecture_id' => '1',
            //     'name' => '台東区',
            //     'latitude' => null,
            //     'longitude' => null,
            // ],
            // [
            //     'prefecture_id' => '1',
            //     'name' => '墨田区',
            //     'latitude' => null,
            //     'longitude' => null,
            // ],
            // [
            //     'prefecture_id' => '1',
            //     'name' => '江東区',
            //     'latitude' => null,
            //     'longitude' => null,
            // ],
            // [
            //     'prefecture_id' => '1',
            //     'name' => '品川区',
            //     'latitude' => null,
            //     'longitude' => null,
            // ],
            // [
            //     'prefecture_id' => '1',
            //     'name' => '目黒区',
            //     'latitude' => null,
            //     'longitude' => null,
            // ],
            // [
            //     'prefecture_id' => '1',
            //     'name' => '大田区',
            //     'latitude' => null,
            //     'longitude' => null,
            // ],
            // [
            //     'prefecture_id' => '1',
            //     'name' => '世田谷区',
            //     'latitude' => null,
            //     'longitude' => null,
            // ],
            // [
            //     'prefecture_id' => '1',
            //     'name' => '渋谷区',
            //     'latitude' => null,
            //     'longitude' => null,
            // ],
            // [
            //     'prefecture_id' => '1',
            //     'name' => '中野区',
            //     'latitude' => null,
            //     'longitude' => null,
            // ],
            // [
            //     'prefecture_id' => '1',
            //     'name' => '杉並区',
            //     'latitude' => null,
            //     'longitude' => null,
            // ],
            // [
            //     'prefecture_id' => '1',
            //     'name' => '豊島区',
            //     'latitude' => null,
            //     'longitude' => null,
            // ],
            // [
            //     'prefecture_id' => '1',
            //     'name' => '北区',
            //     'latitude' => null,
            //     'longitude' => null,
            // ],
            // [
            //     'prefecture_id' => '1',
            //     'name' => '荒川区',
            //     'latitude' => null,
            //     'longitude' => null,
            // ],
            // [
            //     'prefecture_id' => '1',
            //     'name' => '板橋区',
            //     'latitude' => null,
            //     'longitude' => null,
            // ],
            // [
            //     'prefecture_id' => '1',
            //     'name' => '練馬区',
            //     'latitude' => null,
            //     'longitude' => null,
            // ],
            // [
            //     'prefecture_id' => '1',
            //     'name' => '足立区',
            //     'latitude' => null,
            //     'longitude' => null,
            // ],
            // [
            //     'prefecture_id' => '1',
            //     'name' => '葛飾区',
            //     'latitude' => null,
            //     'longitude' => null,
            // ],
            // [
            //     'prefecture_id' => '1',
            //     'name' => '江戸川区',
            //     'latitude' => null,
            //     'longitude' => null,
            // ],
            // [
            //     'prefecture_id' => '2',
            //     'name' => '横浜市',
            //     'latitude' => null,
            //     'longitude' => null,
            // ],
            // [
            //     'prefecture_id' => '2',
            //     'name' => '川崎市',
            //     'latitude' => null,
            //     'longitude' => null,
            // ],
            // [
            //     'prefecture_id' => '2',
            //     'name' => '相模原市',
            //     'latitude' => null,
            //     'longitude' => null,
            // ],
            // [
            //     'prefecture_id' => '2',
            //     'name' => '横須賀市',
            //     'latitude' => null,
            //     'longitude' => null,
            // ],
            // [
            //     'prefecture_id' => '2',
            //     'name' => '平塚市',
            //     'latitude' => null,
            //     'longitude' => null,
            // ],
            // [
            //     'prefecture_id' => '2',
            //     'name' => '鎌倉市',
            //     'latitude' => null,
            //     'longitude' => null,
            // ],
            // [
            //     'prefecture_id' => '2',
            //     'name' => '藤沢市',
            //     'latitude' => null,
            //     'longitude' => null,
            // ],
            // [
            //     'prefecture_id' => '2',
            //     'name' => '小田原市',
            //     'latitude' => null,
            //     'longitude' => null,
            // ],
            // [
            //     'prefecture_id' => '2',
            //     'name' => '茅ヶ崎市',
            //     'latitude' => null,
            //     'longitude' => null,
            // ],
            // [
            //     'prefecture_id' => '2',
            //     'name' => '逗子市',
            //     'latitude' => null,
            //     'longitude' => null,
            // ],
            // [
            //     'prefecture_id' => '2',
            //     'name' => '三浦市',
            //     'latitude' => null,
            //     'longitude' => null,
            // ],
            // [
            //     'prefecture_id' => '2',
            //     'name' => '秦野市',
            //     'latitude' => null,
            //     'longitude' => null,
            // ],
            // [
            //     'prefecture_id' => '2',
            //     'name' => '厚木市',
            //     'latitude' => null,
            //     'longitude' => null,
            // ],
            // [
            //     'prefecture_id' => '2',
            //     'name' => '大和市',
            //     'latitude' => null,
            //     'longitude' => null,
            // ],
            // [
            //     'prefecture_id' => '2',
            //     'name' => '伊勢原市',
            //     'latitude' => null,
            //     'longitude' => null,
            // ],
            // [
            //     'prefecture_id' => '2',
            //     'name' => '海老名市',
            //     'latitude' => null,
            //     'longitude' => null,
            // ],
            // [
            //     'prefecture_id' => '2',
            //     'name' => '座間市',
            //     'latitude' => null,
            //     'longitude' => null,
            // ],
            // [
            //     'prefecture_id' => '2',
            //     'name' => '南足柄市',
            //     'latitude' => null,
            //     'longitude' => null,
            // ],
            // [
            //     'prefecture_id' => '2',
            //     'name' => '綾瀬市',
            //     'latitude' => null,
            //     'longitude' => null,
            // ],
            // [
            //     'prefecture_id' => '2',
            //     'name' => '葉山町',
            //     'latitude' => null,
            //     'longitude' => null,
            // ],
            // [
            //     'prefecture_id' => '2',
            //     'name' => '寒川町',
            //     'latitude' => null,
            //     'longitude' => null,
            // ],
            // [
            //     'prefecture_id' => '2',
            //     'name' => '大磯町',
            //     'latitude' => null,
            //     'longitude' => null,
            // ],
            // [
            //     'prefecture_id' => '2',
            //     'name' => '二宮町',
            //     'latitude' => null,
            //     'longitude' => null,
            // ],
            // [
            //     'prefecture_id' => '2',
            //     'name' => '中井町',
            //     'latitude' => null,
            //     'longitude' => null,
            // ],
            // [
            //     'prefecture_id' => '2',
            //     'name' => '大井町',
            //     'latitude' => null,
            //     'longitude' => null,
            // ],
            // [
            //     'prefecture_id' => '2',
            //     'name' => '松田町',
            //     'latitude' => null,
            //     'longitude' => null,
            // ],
            // [
            //     'prefecture_id' => '2',
            //     'name' => '山北町',
            //     'latitude' => null,
            //     'longitude' => null,
            // ],
            // [
            //     'prefecture_id' => '2',
            //     'name' => '開成町',
            //     'latitude' => null,
            //     'longitude' => null,
            // ],
            // [
            //     'prefecture_id' => '2',
            //     'name' => '箱根町',
            //     'latitude' => null,
            //     'longitude' => null,
            // ],
            // [
            //     'prefecture_id' => '2',
            //     'name' => '真鶴町',
            //     'latitude' => null,
            //     'longitude' => null,
            // ],
            // [
            //     'prefecture_id' => '2',
            //     'name' => '湯河原町',
            //     'latitude' => null,
            //     'longitude' => null,
            // ],
            // [
            //     'prefecture_id' => '2',
            //     'name' => '愛川町',
            //     'latitude' => null,
            //     'longitude' => null,
            // ],
            // [
            //     'prefecture_id' => '2',
            //     'name' => '清川村',
            //     'latitude' => null,
            //     'longitude' => null,
            // ],
        ]);
        Excel::import(
            new CitiesImport,
            storage_path('app/data/cities.csv')
        );
    }
}
