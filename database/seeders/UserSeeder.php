<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'admin',
                'email' => 'test@test.com',
                'password' => Hash::make('test'),
                'role' => 'admin',
                'is_active' => '1',
                'prefecture_id' => '1',
                'city_id' => '1',
            ],
        ]);
    }
}
