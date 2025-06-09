<?php

namespace App\Services;

use App\Models\FittingTolerance;

class FittingToleranceService
{
    public static function getDefaultValues(): array
    {
        return [
            'kitake_length-just' => [
                "min_value" => -4.0,
                "max_value" => 4.0
            ],
            'kitake_length-slight' => [
                "min_value" => -8.0,
                "max_value" => 8.0
            ],
            'kitake_length-long_or_short' => [
                "min_value" => -12.0,
                "max_value" => 12.0
            ],
            'neck_circumference-just' => [
                "min_value" => -0.5,
                "max_value" => 1.0
            ],
            'neck_circumference-slight' => [
                "min_value" => -1.0,
                "max_value" => 2.0
            ],
            'neck_circumference-long_or_short' => [
                "min_value" => -2.0,
                "max_value" => 3.0
            ],
            'shoulder_width-just' => [
                "min_value" => -1.0,
                "max_value" => 2.0
            ],
            'shoulder_width-slight' => [
                "min_value" => -2.0,
                "max_value" => 4.0
            ],
            'shoulder_width-long_or_short' => [
                "min_value" => -4.0,
                "max_value" => 6.0
            ],
            'yuki_length-just' => [
                "min_value" => -3.0,
                "max_value" => 3.0
            ],
            'yuki_length-slight' => [
                "min_value" => -6.0,
                "max_value" => 6.0
            ],
            'yuki_length-long_or_short' => [
                "min_value" => -9.0,
                "max_value" => 9.0
            ],
            'sleeve_length-just' => [
                "min_value" => -3.0,
                "max_value" => 3.0
            ],
            'sleeve_length-slight' => [
                "min_value" => -6.0,
                "max_value" => 6.0
            ],
            'sleeve_length-long_or_short' => [
                "min_value" => -9.0,
                "max_value" => 9.0
            ],
            'chest_circumference-just' => [
                "min_value" => -3.0,
                "max_value" => 3.0
            ],
            'chest_circumference-slight' => [
                "min_value" => -6.0,
                "max_value" => 4.0
            ],
            'chest_circumference-long_or_short' => [
                "min_value" => -9.0,
                "max_value" => 6.0
            ],
            'armpit_to_armpit_width-just' => [
                "min_value" => -1.5,
                "max_value" => 1.5
            ],
            'armpit_to_armpit_width-slight' => [
                "min_value" => -3.0,
                "max_value" => 2.0
            ],
            'armpit_to_armpit_width-long_or_short' => [
                "min_value" => -4.5,
                "max_value" => 3.0
            ],
            'waist-just' => [
                "min_value" => -1.0,
                "max_value" => 1.0
            ],
            'waist-slight' => [
                "min_value" => -3.0,
                "max_value" => 3.0
            ],
            'waist-long_or_short' => [
                "min_value" => -5.0,
                "max_value" => 5.0
            ],
            'inseam-just' => [
                "min_value" => -1.5,
                "max_value" => 1.5
            ],
            'inseam-slight' => [
                "min_value" => -3.0,
                "max_value" => 3.0
            ],
            'inseam-long_or_short' => [
                "min_value" => -5.0,
                "max_value" => 5.0
            ],
            'hip-just' => [
                "min_value" => -1.0,
                "max_value" => 1.0
            ],
            'hip-slight' => [
                "min_value" => -3.0,
                "max_value" => 3.0
            ],
            'hip-long_or_short' => [
                "min_value" => -5.0,
                "max_value" => 5.0
            ],
        ];
    }

    public static function getValidationRules(): array
    {
        $rules = [];
        foreach (self::getDefaultValues() as $key => $values) {
            // .記法でネストされたキーを指定する
            $rules["tolerances.$key.min_value"] = 'required|numeric|between:-15.0,15.0';
            $rules["tolerances.$key.max_value"] = 'required|numeric|between:-15.0,15.0';
        }
        // dd($rules);
        return $rules;
    }

    public static function getForUser($userId)
    {
        $raw = FittingTolerance::where('user_id', $userId)->get();
        $userTolerance = [];

        foreach ($raw as $tolerance) {
            $userTolerance[$tolerance->body_part][$tolerance->tolerance_level] = [
                'min_value' => $tolerance->min_value,
                'max_value' => $tolerance->max_value,
            ];
        }

        return $userTolerance;
    }
}
