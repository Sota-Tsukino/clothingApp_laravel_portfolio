<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CoordinateWearingLog;

class WeatherType extends Model
{
    use HasFactory;

    protected $fillable = [
        'weather_icon_filename',
        'label',
        'openweather_code',
        'description',
    ];

    public function CoordinateWearingLog()
    {
        return $this->hasMany(CoordinateWearingLog::class);
    }
}
