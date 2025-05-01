<?php

namespace App\Services;


class FittingToleranceService
{
    public static function getDefaultValues(): array
    {
        return [
            'yuki_length-just' => [
                "min_value" => -1.5,
                "max_value" => 1.5
            ],
            'yuki_length-slight' => [
                "min_value" => -3.0,
                "max_value" => 3.0
            ],
            'yuki_length-long_or_short' => [
                "min_value" => -5.0,
                "max_value" => 5.0
            ],
            'neck_circumference-just' => [
                "min_value" => -0.5,
                "max_value" => 0.5
            ],
            'neck_circumference-slight' => [
                "min_value" => -1.0,
                "max_value" => 1.5
            ],
            'neck_circumference-long_or_short' => [
                "min_value" => -2.0,
                "max_value" => 2.5
            ],
            'chest_circumference-just' => [
                "min_value" => -1.5,
                "max_value" => 1.5
            ],
            'chest_circumference-slight' => [
                "min_value" => -3.0,
                "max_value" => 3.0
            ],
            'chest_circumference-long_or_short' => [
                "min_value" => -5.0,
                "max_value" => 5.0
            ],
            'waist-just' => [
                "min_value" => -1.0,
                "max_value" => 1.0
            ],
            'waist-slight' => [
                "min_value" => -2.5,
                "max_value" => 2.5
            ],
            'waist-long_or_short' => [
                "min_value" => -4.0,
                "max_value" => 4.0
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
                "min_value" => -1.5,
                "max_value" => 1.5
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
            $rules["tolerances.$key.min_value"] = 'required|numeric|between:-10.0,10.0';
            $rules["tolerances.$key.max_value"] = 'required|numeric|between:-10.0,10.0';
        }
        // dd($rules);
        return $rules;
    }
}
