<?php

namespace Database\Seeders;

use App\Imports\SceneTagImport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class SceneTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Excel::import(new SceneTagImport, storage_path('app/data/sceneTags.csv'));
    }
}
