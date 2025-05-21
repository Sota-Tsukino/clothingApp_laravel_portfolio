<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Coordinate;

class SceneTag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function coordinates()
    {
        return $this->hasMany(Coordinate::class);
    }
}
