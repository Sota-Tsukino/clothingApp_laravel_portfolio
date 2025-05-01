<?php

namespace App\Services;

use App\Models\BodyCorrection;
use App\Models\FittingTolerance;
use App\Services\FittingToleranceService;

class UserInitializationService//編集中
{

    public function initialize(int $userId): void
    {
        $this->createDefaultBodyCorrection($userId);
        // $this->createDefaultFittingTolerance($userId);
    }

    public function createDefaultBodyCorrection(int $userId): void
    {
        if (!BodyCorrection::where('user_id', $userId)->exists()) {
            BodyCorrection::create(['user_id' => $userId]);
        }
    }

    public function createDefaultFittingTolerance(int $userId): void
    {
        if (!FittingTolerance::where('user_id', $userId)->exists()) {
            $defaultValues = app(FittingToleranceService::class)->getDefaultValues();
            foreach ($defaultValues as $key => $range) {
                [$bodypart, $fitType] = explode('-', $key);
                FittingTolerance::create([
                    'user_id' => $userId,
                    'body_part' => $bodypart,
                    'tolerance_level' => $fitType,
                    'min_value' => $range['min_value'],
                    'max_value' => $range['max_value'],
                ]);
            }
        }
    }
}
