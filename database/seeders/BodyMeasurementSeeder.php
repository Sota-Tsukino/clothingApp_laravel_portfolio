<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BodyMeasurementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('body_measurements')->insert([
            [
                'user_id' => '1',
                'measured_at' => '2025/05/30',
                'height' => '157.1',
                'head_circumference' => '58.5',
                'neck_circumference' => '36.0',
                'shoulder_width' => '40.5',
                'chest_circumference' => '77.5',
                // 'armpit_to_armpit_width' => '38.75',
                'waist' => '71',
                'hip' => '80',
                'sleeve_length' => '56.0',
                'yuki_length' => '76.0',
                'inseam' => '67.0',
                'foot_length' => '23.5',
                'foot_circumference' => '24.0',
            ],
            [
                'user_id' => '1',
                'measured_at' => '2024/01/02',
                'height' => '144.1',
                'head_circumference' => '33.5',
                'neck_circumference' => '44.2',
                'shoulder_width' => '34.5',
                'chest_circumference' => '26.5',
                'waist' => '65.2',
                'hip'=> '77',
                'sleeve_length' => '45.0',
                'yuki_length' => '78.0',
                'inseam' => '34.0',
                'foot_length' => '11.5',
                'foot_circumference' => '22.0',
            ],
            [
                'user_id' => '2',
                'measured_at' => '2024/01/02',
                'height' => '144.1',
                'head_circumference' => '33.5',
                'neck_circumference' => '44.2',
                'shoulder_width' => '34.5',
                'chest_circumference' => '26.5',
                'waist' => '65.2',
                'hip'=> '77',
                'sleeve_length' => '45.0',
                'yuki_length' => '78.0',
                'inseam' => '34.0',
                'foot_length' => '11.5',
                'foot_circumference' => '22.0',
            ],
        ]);
    }
}
