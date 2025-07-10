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
                'created_at' => '2025/06/15'
            ],
            [
                'nickname' => 'user1',
                'email' => 'test1@test.com',
                'password' => Hash::make('test'),
                'role' => 'user',
                'is_active' => '1',
                'gender' => 'prefer_not_to_say',
                'prefecture_id' => '1',
                'city_id' => '1',
                'created_at' => '2025/06/14'
            ],
            [
                'nickname' => 'user2',
                'email' => 'test2@test.com',
                'password' => Hash::make('test'),
                'role' => 'user',
                'is_active' => '1',
                'gender' => 'prefer_not_to_say',
                'prefecture_id' => '1',
                'city_id' => '1',
                'created_at' => '2025/06/13'
            ],
            [
                'nickname' => 'user3',
                'email' => 'test3@test.com',
                'password' => Hash::make('test'),
                'role' => 'user',
                'is_active' => '1',
                'gender' => 'prefer_not_to_say',
                'prefecture_id' => '1',
                'city_id' => '1',
                'created_at' => '2025/06/12'
            ],
            [
                'nickname' => 'user4',
                'email' => 'test4@test.com',
                'password' => Hash::make('test'),
                'role' => 'user',
                'is_active' => '1',
                'gender' => 'prefer_not_to_say',
                'prefecture_id' => '1',
                'city_id' => '1',
                'created_at' => '2025/06/11'
            ],
            [
                'nickname' => 'user5',
                'email' => 'test5@test.com',
                'password' => Hash::make('test'),
                'role' => 'user',
                'is_active' => '1',
                'gender' => 'prefer_not_to_say',
                'prefecture_id' => '1',
                'city_id' => '1',
                'created_at' => '2025/06/10'
            ],
            [
                'nickname' => 'user6',
                'email' => 'test6@test.com',
                'password' => Hash::make('test'),
                'role' => 'user',
                'is_active' => '1',
                'gender' => 'prefer_not_to_say',
                'prefecture_id' => '1',
                'city_id' => '1',
                'created_at' => '2025/06/09'
            ],
            [
                'nickname' => 'user7',
                'email' => 'test7@test.com',
                'password' => Hash::make('test'),
                'role' => 'user',
                'is_active' => '1',
                'gender' => 'prefer_not_to_say',
                'prefecture_id' => '1',
                'city_id' => '1',
                'created_at' => '2025/06/08'
            ],
            [
                'nickname' => 'user8',
                'email' => 'test8@test.com',
                'password' => Hash::make('test'),
                'role' => 'user',
                'is_active' => '1',
                'gender' => 'prefer_not_to_say',
                'prefecture_id' => '1',
                'city_id' => '1',
                'created_at' => '2025/06/07'
            ],
            [
                'nickname' => 'user9',
                'email' => 'test9@test.com',
                'password' => Hash::make('test'),
                'role' => 'user',
                'is_active' => '1',
                'gender' => 'prefer_not_to_say',
                'prefecture_id' => '1',
                'city_id' => '1',
                'created_at' => '2025/06/06'
            ],
            [
                'nickname' => 'user10',
                'email' => 'test10@test.com',
                'password' => Hash::make('test'),
                'role' => 'user',
                'is_active' => '1',
                'gender' => 'prefer_not_to_say',
                'prefecture_id' => '1',
                'city_id' => '1',
                'created_at' => '2025/06/05'
            ],
            [
                'nickname' => 'user11',
                'email' => 'test11@test.com',
                'password' => Hash::make('test'),
                'role' => 'user',
                'is_active' => '1',
                'gender' => 'prefer_not_to_say',
                'prefecture_id' => '1',
                'city_id' => '1',
                'created_at' => '2025/06/05'
            ],
            [
                'nickname' => 'user12',
                'email' => 'test12@test.com',
                'password' => Hash::make('test'),
                'role' => 'user',
                'is_active' => '1',
                'gender' => 'prefer_not_to_say',
                'prefecture_id' => '1',
                'city_id' => '1',
                'created_at' => '2025/06/05'
            ],
            [
                'nickname' => 'user13',
                'email' => 'test13@test.com',
                'password' => Hash::make('test'),
                'role' => 'user',
                'is_active' => '1',
                'gender' => 'prefer_not_to_say',
                'prefecture_id' => '1',
                'city_id' => '1',
                'created_at' => '2025/06/05'
            ],
            [
                'nickname' => 'user14',
                'email' => 'test14@test.com',
                'password' => Hash::make('test'),
                'role' => 'user',
                'is_active' => '1',
                'gender' => 'prefer_not_to_say',
                'prefecture_id' => '1',
                'city_id' => '1',
                'created_at' => '2025/06/05'
            ],
            [
                'nickname' => 'user15',
                'email' => 'test15@test.com',
                'password' => Hash::make('test'),
                'role' => 'user',
                'is_active' => '1',
                'gender' => 'prefer_not_to_say',
                'prefecture_id' => '1',
                'city_id' => '1',
                'created_at' => '2025/06/05'
            ],
        ]);
    }
}
