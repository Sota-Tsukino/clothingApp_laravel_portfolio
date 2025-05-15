<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Item;

class Season extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    //中間テーブル（多：多）なのでmethod名 複数形に
    public function items()
    {
        return $this->belongsToMany(Item::class, 'item_seasons');
    }
}
