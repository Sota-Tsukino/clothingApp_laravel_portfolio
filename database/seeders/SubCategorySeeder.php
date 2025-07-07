<?php

namespace Database\Seeders;

use App\Imports\SubCategoriesImport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class SubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Excel::import(new SubCategoriesImport, storage_path('app/data/subCategories.csv'));
    }
}
