<?php

namespace App\Services;

class ItemRecommendationService
{

    public static function recommendByTemperature(float $temperature): array
    {
        // dd($temperature);
        foreach (config('clothing_recommendations.temperature_ranges') as $range) {
            if (($range['min'] === null || $temperature >= $range['min']) &&
                ($range['max'] === null || $temperature < $range['max'])
            ) {
                return [
                    'tops' => $range['tops'],
                    'bottoms' => $range['bottoms'],
                    'outers' => $range['outers'],
                ];
            }
        }
        return [];
    }
}
