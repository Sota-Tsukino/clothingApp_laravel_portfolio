<?php

namespace App\Services;

use App\Models\BodyCorrection;

class BodyCorrectionService
{
    public static array $fieldsDefaultValues = [
        'head_circumference' => 2.0,
        'neck_circumference' => 2.0,
        'shoulder_width' => 2.0,
        'chest_circumference' => 3.0,
        'waist' => 2.0,
        'hip' => 2.0,
        'sleeve_length' => 0.0,
        'yuki_length' => 0.0,
        'inseam' => 0.0,
        'foot_length' => 1.0,
        'foot_circumference' => 0.0,
    ];

    public static function getValidationRules(): array
    {
        $rules = [];
        $fieldKeys = array_keys(self::$fieldsDefaultValues);
        foreach ($fieldKeys as $field) {
            $rules[$field] = 'numeric|between:0,9';
        }
        return $rules;
    }

    public static function getForUser($userId)
    {
        return BodyCorrection::findOrFail($userId);
    }
}
