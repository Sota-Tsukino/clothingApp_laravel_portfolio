<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Item;

class Category extends Model
{
    use HasFactory;

    public function item()
    {
        // 1itemにつきカテゴリーは１つだけ選択なのでhasOne()?
        //もしくは複数のitemで同じカテゴリーが選択される可能性があるのでhasmany()か？
        return $this->hasMany(Item::class);
    }
}
