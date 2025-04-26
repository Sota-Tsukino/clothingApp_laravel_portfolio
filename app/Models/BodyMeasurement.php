<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use app\Models\User;

class BodyMeasurement extends Model
{
    use HasFactory;

    // BodyMeasurement.php
    //※モデル名がBodyMeasurementならEloquentが自動でbody_measurements tableお対応させるが念のため明記
    protected $table = 'body_measurements';

    protected $fillable = [
        'user_id',
        'measured_at',
        'height',
        'head_circumference',
        'neck_circumference',
        'shoulder_width',
        'chest_circumference',
        'waist',
        'hip',
        'sleeve_length',
        'yuki_length',
        'inseam',
        'foot_length',
        'foot_circumference',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
