<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class FittingTolerance extends Model
{
    use HasFactory;

    protected $table = 'fitting_tolerances';

    protected $fillable = [
        'user_id',
        'body_part',
        'tolerance_level',
        'min_value',
        'max_value',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
