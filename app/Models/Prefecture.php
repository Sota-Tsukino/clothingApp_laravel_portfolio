<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\City;
use App\Models\User;
use App\Models\CoordinateWearingLog;

class Prefecture extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function city()
    {
        return $this->hasMany(City::class);
    }

    public function CoordinateWearingLog()
    {
        return $this->hasMany(CoordinateWearingLog::class);
    }
}
