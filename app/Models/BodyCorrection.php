<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use app\Models\User;

class BodyCorrection extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kitake_length',
        'head_circumference',
        'neck_circumference',
        'shoulder_width',
        'chest_circumference',
        'armpit_to_armpit_width',
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
