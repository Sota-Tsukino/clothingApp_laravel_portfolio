<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Imports\PrefecturesImport;
use Maatwebsite\Excel\Facades\Excel;

class PrefectureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::table('prefectures')->insert([
        //     [
        //         'name' => '東京都',
        //     ],
        //     [
        //         'name' => '神奈川',
        //     ],
        // ]);
        Excel::import(new PrefecturesImport,
        storage_path('app/data/prefectures.csv'));
    }
}
