<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Prefecture;
use App\Models\User;

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
}
