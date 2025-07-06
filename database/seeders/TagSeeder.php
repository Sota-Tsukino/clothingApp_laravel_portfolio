<?php

namespace Database\Seeders;

use App\Imports\TagImport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         Excel::import(new TagImport, storage_path('app/data/tags.csv'));
    }
}
