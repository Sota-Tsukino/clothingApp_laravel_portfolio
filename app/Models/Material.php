<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Item;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function item()
    {
        // 1つの素材が複数のItemに使われる可能性があるのでhasMany()
        return $this->hasMany(Item::class, 'main_material_id')->orWhere('sub_material_id', $this->id);
    }
}
