<?php

namespace App\Services;


class SizeCheckerService
{
    public static function getFields()
    {
        return [
            'total_length',
            'kitake_length',
            'neck_circumference',
            'shoulder_width',
            'yuki_length',
            'sleeve_length',
            'chest_circumference',
            'armpit_to_armpit_width',
            'waist',
            'inseam',
            'hip',
        ];
    }

    public static function getSuitableSize($bodyMeasurement, $bodyCorrection)
    {
        $fields = self::getFields();
        $suitableSize = [];

        foreach ($fields as $field) {
            $suitableSize[$field] = $bodyMeasurement->$field + $bodyCorrection->$field;
        }

        return $suitableSize;
    }

    public static function getItemSize($item)
    {
        $fields = self::getFields();
        $itemSize = [];

        foreach ($fields as $field) {
            $itemSize[$field] = $item->$field;
        }

        return $itemSize;
    }
}
