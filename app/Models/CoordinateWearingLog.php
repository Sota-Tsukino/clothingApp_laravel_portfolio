<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\WeatherType;
use App\Models\Prefecture;

class CoordinateWearingLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'coordinate_id',
        'user_id',
        'worn_at',
        'weather_day_type_id',
        'weather_night_type_id',
        'status',
        'min_temperature',
        'max_temperature',
        'prefecture_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function weatherDayType()
    {
        return $this->belongsTo(WeatherType::class, 'weather_day_type_id');
    }

    public function weatherNightType()
    {
        return $this->belongsTo(WeatherType::class, 'weather_night_type_id');
    }
    
    public function coordinate()
    {
        return $this->belongsTo(Coordinate::class);
    }

    public function prefecture()
    {
        return $this->belongsTo(Prefecture::class);
    }
}
