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
                'nickname' => 'admin',
                'email' => 'test@test.com',
                'password' => Hash::make('test'),
                'role' => 'admin',
                'is_active' => '1',
                'gender' => 'prefer_not_to_say',
                'prefecture_id' => '1',
                'city_id' => '1',
            ],
            // [
            //     'nickname' => 'user1',
            //     'email' => 'tes1t@test.com',
            //     'password' => Hash::make('test'),
            //     'role' => 'user',
            //     'is_active' => '1',
            //     'gender' => 'prefer_not_to_say',
            //     'prefecture_id' => '1',
            //     'city_id' => '1',
            // ],
            // [
            //     'nickname' => 'user2',
            //     'email' => 'test2@test.com',
            //     'password' => Hash::make('test'),
            //     'role' => 'user',
            //     'is_active' => '1',
            //     'gender' => 'prefer_not_to_say',
            //     'prefecture_id' => '1',
            //     'city_id' => '1',
            // ],
        ]);
    }
}
