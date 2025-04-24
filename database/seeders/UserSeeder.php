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
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'is_active' => '1',
                'prefecture_id' => '1',
                'city_id' => '1',
            ],
            [
                'name' => 'user1',
                'email' => 'test1@test.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'is_active' => '1',
                'prefecture_id' => '1',
                'city_id' => '2',
            ],
            [
                'name' => 'user2',
                'email' => 'test2@test.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'is_active' => '1',
                'prefecture_id' => '1',
                'city_id' => '3',
            ],
            [
                'name' => 'user3',
                'email' => 'test3@test.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'is_active' => '1',
                'prefecture_id' => '1',
                'city_id' => '3',
            ],
        ]);
    }
}
