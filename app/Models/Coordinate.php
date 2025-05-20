<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\SceneTag;
use App\Models\Item;
use App\Models\CoordinateWearingLog;
use App\Constants\Common;

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

    public function scopeOfUser($query, $userId)
    {
        return $query->with(['items.image', 'sceneTag'])
            ->where('user_id', $userId);
    }

    public function scopeIsFavorite($query, $flag)
    {
        if ($flag === '0' || $flag === '1') {
            return $query->where('is_favorite', (bool)$flag);
        }
        return $query;
    }

    public function scopeSortOrder($query, $sortOrder)
    {
        switch ($sortOrder) {
            case Common::SORT_ORDER['oldRegisteredItem']:
                return $query->orderBy('created_at', 'asc');
            default:
                return $query->orderBy('created_at', 'desc');
        }
    }
}
