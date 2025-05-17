<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\SceneTag;
use App\Models\Item;
use App\Models\CoordinateWearingLog;

class Coordinate extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'scene_tag_id',
        'is_public',
        'memo',
        'is_favorite',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sceneTag()
    {
        return $this->belongsTo(SceneTag::class);
    }

    //中間テーブル
    public function items()
    {
        return $this->belongsToMany(Item::class, 'item_coordinates')
            ->withTimestamps();
    }

    public function CoordinateWearingLog()
    {
        return $this->hasMany(CoordinateWearingLog::class);
    }
}
