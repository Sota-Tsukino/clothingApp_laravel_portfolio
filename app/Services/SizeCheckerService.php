<?php

namespace App\Services;


class SizeCheckerService
{
    public static function getFields()
    {
        return [
            'neck_circumference',
            'shoulder_width',
            'yuki_length',
            'chest_circumference',
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
