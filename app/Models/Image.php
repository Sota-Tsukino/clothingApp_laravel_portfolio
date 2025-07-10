<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Item;
use App\Models\User;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'file_name',
    ];

    public function item()
    {
        //1画像が1のアイテムに使われる前提
        return $this->hasOne(Item::class);
    }

    public function user()
    {
        //１画像は１ユーザーのもの
        return $this->belongsTo(User::class);
    }
}
