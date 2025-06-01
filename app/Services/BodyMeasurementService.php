<?php

namespace App\Services;

use App\Models\BodyMeasurement;

class BodyMeasurementService
{
    public static function getFields(): array
    {
        return [
            'height',
            'kitake_length',
            'head_circumference',
            'neck_circumference',
            'shoulder_width',
            'yuki_length',
            'sleeve_length',
            'chest_circumference',
            'armpit_to_armpit_width',
            'waist',
            'hip',
            'inseam',
            'foot_length',
            'foot_circumference',
        ];
    }

    public static function getValidationRules(bool $withDate = false): array
    {
        $rules = [];
        if ($withDate) {
            $rules['measured_at'] = 'date|required|before_or_equal:today';
        }
        foreach (self::getFields() as $field) {
            $rules[$field] = 'nullable|numeric|between:0,999.0';
        }
        return $rules;
    }

    public static function getLatestForUser($userId)
    {
        return BodyMeasurement::where('user_id', $userId)
            ->orderBy('measured_at', 'desc')
            ->firstOrFail();
    }
}
