<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FittingTolerance extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('fitting_tolerances')->insert([
            [
                'user_id' => '1',
                'body_part' => 'kitake_length',
                'tolerance_level' => 'just',
                "min_value" => -4.0,
                "max_value" => 4.0
            ],
            [
                'user_id' => '1',
                'body_part' => 'kitake_length',
                'tolerance_level' => 'slight',
                "min_value" => -8.0,
                "max_value" => 8.0
            ],
            [
                'user_id' => '1',
                'body_part' => 'kitake_length',
                'tolerance_level' => 'long_or_short',
                "min_value" => -12.0,
                "max_value" => 12.0
            ],
            [
                'user_id' => '1',
                'body_part' => 'neck_circumference',
                'tolerance_level' => 'just',
                "min_value" => -0.5,
                "max_value" => 1.0
            ],
            [
                'user_id' => '1',
                'body_part' => 'neck_circumference',
                'tolerance_level' => 'slight',
                "min_value" => -1.0,
                "max_value" => 2.0
            ],
            [
                'user_id' => '1',
                'body_part' => 'neck_circumference',
                'tolerance_level' => 'long_or_short',
                "min_value" => -2.0,
                "max_value" => 3.0
            ],
            [
                'user_id' => '1',
                'body_part' => 'yuki_length',
                'tolerance_level' => 'just',
                "min_value" => -3.0,
                "max_value" => 3.0
            ],
            [
                'user_id' => '1',
                'body_part' => 'yuki_length',
                'tolerance_level' => 'slight',
                "min_value" => -6.0,
                "max_value" => 6.0
            ],
            [
                'user_id' => '1',
                'body_part' => 'yuki_length',
                'tolerance_level' => 'long_or_short',
                "min_value" => -9.0,
                "max_value" => 9.0
            ],
            [
                'user_id' => '1',
                'body_part' => 'sleeve_length',
                'tolerance_level' => 'just',
                "min_value" => -3.0,
                "max_value" => 3.0
            ],
            [
                'user_id' => '1',
                'body_part' => 'sleeve_length',
                'tolerance_level' => 'slight',
                "min_value" => -6.0,
                "max_value" => 6.0
            ],
            [
                'user_id' => '1',
                'body_part' => 'sleeve_length',
                'tolerance_level' => 'long_or_short',
                "min_value" => -9.0,
                "max_value" => 9.0
            ],
            [
                'user_id' => '1',
                'body_part' => 'shoulder_width',
                'tolerance_level' => 'just',
                'min_value' => '-1.0',
                'max_value' => '2.0',
            ],
            [
                'user_id' => '1',
                'body_part' => 'shoulder_width',
                'tolerance_level' => 'slight',
                'min_value' => '-2.0',
                'max_value' => '4.0',
            ],
            [
                'user_id' => '1',
                'body_part' => 'shoulder_width',
                'tolerance_level' => 'long_or_short',
                'min_value' => '-4.0',
                'max_value' => '6.0',
            ],
            [
                'user_id' => '1',
                'body_part' => 'chest_circumference',
                'tolerance_level' => 'just',
                "min_value" => -3.0,
                "max_value" => 3.0
            ],
            [
                'user_id' => '1',
                'body_part' => 'chest_circumference',
                'tolerance_level' => 'slight',
                "min_value" => -6.0,
                "max_value" => 4.0
            ],
            [
                'user_id' => '1',
                'body_part' => 'chest_circumference',
                'tolerance_level' => 'long_or_short',
                "min_value" => -9.0,
                "max_value" => 6.0
            ],
            [
                'user_id' => '1',
                'body_part' => 'armpit_to_armpit_width',
                'tolerance_level' => 'just',
                "min_value" => -1.5,
                "max_value" => 1.5
            ],
            [
                'user_id' => '1',
                'body_part' => 'armpit_to_armpit_width',
                'tolerance_level' => 'slight',
                "min_value" => -3.0,
                "max_value" => 2.0
            ],
            [
                'user_id' => '1',
                'body_part' => 'armpit_to_armpit_width',
                'tolerance_level' => 'long_or_short',
                "min_value" => -4.5,
                "max_value" => 3
            ],
            [
                'user_id' => '1',
                'body_part' => 'waist',
                'tolerance_level' => 'just',
                "min_value" => -1.0,
                "max_value" => 1.0
            ],
            [
                'user_id' => '1',
                'body_part' => 'waist',
                'tolerance_level' => 'slight',
                "min_value" => -3.0,
                "max_value" => 3.0
            ],
            [
                'user_id' => '1',
                'body_part' => 'waist',
                'tolerance_level' => 'long_or_short',
                "min_value" => -5.0,
                "max_value" => 5.0
            ],
            [
                'user_id' => '1',
                'body_part' => 'hip',
                'tolerance_level' => 'just',
                'min_value' => '-1.0',
                'max_value' => '1.0',
            ],
            [
                'user_id' => '1',
                'body_part' => 'hip',
                'tolerance_level' => 'slight',
                'min_value' => '-3.0',
                'max_value' => '3.0',
            ],
            [
                'user_id' => '1',
                'body_part' => 'hip',
                'tolerance_level' => 'long_or_short',
                'min_value' => '-5.0',
                'max_value' => '5.0',
            ],
            [
                'user_id' => '1',
                'body_part' => 'inseam',
                'tolerance_level' => 'just',
                'min_value' => '-1.5',
                'max_value' => '1.5',
            ],
            [
                'user_id' => '1',
                'body_part' => 'inseam',
                'tolerance_level' => 'slight',
                'min_value' => '-3.0',
                'max_value' => '3.0',
            ],
            [
                'user_id' => '1',
                'body_part' => 'inseam',
                'tolerance_level' => 'long_or_short',
                'min_value' => '-5.0',
                'max_value' => '5.0',
            ],
        ]);
    }
}
