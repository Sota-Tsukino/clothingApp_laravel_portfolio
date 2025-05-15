<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Item;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function items()
    {
        //ブランドは複数のitemを持つのでhasMany()
        return $this->hasMany(Item::class);
    }

}
