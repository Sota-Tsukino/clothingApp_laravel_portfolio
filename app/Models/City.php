<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Prefecture;
use App\Models\User;
use App\Services\WeatherService;
use RuntimeException;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'prefecture_id',
        'name',
        'latitude',
        'longitude',
    ];

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function prefecture()
    {
        return $this->belongsTo(Prefecture::class);
    }

    public function ensureCoordinates()
    {
        if (is_null($this->latitude) || is_null($this->longitude)) {
            $coords = WeatherService::fetchCoordinatesByCityName($this->name);

            if (!$coords) {
                throw new RuntimeException('位置情報を取得できませんでした');
            }

            $this->update([
                'latitude' => $coords['latitude'],
                'longitude' => $coords['longitude'],
            ]);
        }
    }
}
