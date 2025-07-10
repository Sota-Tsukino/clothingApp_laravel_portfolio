<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Item;
use App\Models\SubCategory;

class Category extends Model
{
    use HasFactory;

    public function item()
    {
        return $this->hasMany(Item::class);
    }

    public function subCategory()
    {
        return $this->hasMany(SubCategory::class);
    }
}
