<?php

namespace App\Services;

class ItemRecommendationService
{

    public static function recommendByTemperature(float $temperature, string $gender): array
    {
        foreach (config('clothing_recommendations.temperature_ranges') as $range) {
            if (($range['min'] === null || $temperature >= $range['min']) &&
                ($range['max'] === null || $temperature < $range['max'])
            ) {

                if ($gender === 'female') {
                    $topsIds = array_merge($range['tops']['unisex'] ?? [], $range['tops']['female'] ?? []);
                    $bottomsIds = array_merge($range['bottoms']['unisex'] ?? [], $range['bottoms']['female'] ?? []);
                } elseif ($gender === 'male') {
                    $topsIds = $range['tops']['unisex'] ?? [];
                    $bottomsIds = $range['bottoms']['unisex'] ?? [];
                } else { // prefer_not_to_say や null
                    $topsIds = array_merge(
                        $range['tops']['unisex'] ?? [],
                        $range['tops']['female'] ?? []
                    );
                    $bottomsIds = array_merge(
                        $range['bottoms']['unisex'] ?? [],
                        $range['bottoms']['female'] ?? []
                    );
                }
                return [
                    'tops' => $topsIds,
                    'bottoms' => $bottomsIds,
                    'outers' => $range['outers'],
                ];
            }
        }
        return [];
    }
}
