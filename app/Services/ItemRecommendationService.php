<?php

namespace App\Services;

class ItemRecommendationService
{

    public static function recommendByTemperature(int $temperature): array
    {
        $range = self::getTemperatureRange($temperature);

        $categories = config("clothing_recommendations.temperature_ranges.$range");

        return $categories ?? [];
    }

    public static function getTemperatureRange(int $temp): string
    {
        return match (true) {
            $temp >= 30 => '30+',
            $temp >= 25 => '25-29',
            $temp >= 21 => '21-24',
            $temp >= 17 => '17-20',
            $temp >= 13 => '13-16',
            $temp >= 9  => '9-12',
            $temp >= 6  => '6-8',
            default     => 'under5',
        };
    }
}
