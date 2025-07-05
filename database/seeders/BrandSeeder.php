<?php

namespace Database\Seeders;

use App\Imports\BrandsImport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::table('brands')->insert([
        //     [
        //         'name' => '不明',
        //     ],
        //     [
        //         'name' => 'UNIQLO',
        //     ],
        //     [
        //         'name' => 'GU',
        //     ],
        //     [
        //         'name' => 'MUJI',
        //     ],
        //     [
        //         'name' => 'ZARA',
        //     ],
        //     [
        //         'name' => 'GAP',
        //     ],
        //     [
        //         'name' => 'H&M',
        //     ],
        // ]);
        Excel::import(
            new BrandsImport,
            storage_path('app/data/brands.csv')
        );
    }
}
