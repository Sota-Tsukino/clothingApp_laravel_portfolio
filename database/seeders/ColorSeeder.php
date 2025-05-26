<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Imports\ColorsImport;
use Maatwebsite\Excel\Facades\Excel;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::table('colors')->insert([
        //     [
        //         'name' => 'white',
        //         'hex_code' => '#ffffff',
        //     ],
        //     [
        //         'name' => 'black',
        //         'hex_code' => '#000000',
        //     ],
        //     [
        //         'name' => 'red',
        //         'hex_code' => '#ff0000',
        //     ],
        //     [
        //         'name' => 'blue',
        //         'hex_code' => '#0000ff',
        //     ],
        // ]);
        Excel::import(new ColorsImport, storage_path('app/data/colors.csv'));
    }
}
