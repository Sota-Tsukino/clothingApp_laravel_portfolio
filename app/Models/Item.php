<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Brand;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Image;
use App\Models\Material;
use App\Models\Color;
use App\Models\Season;
use App\Models\Tag;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'image_id',
        'category_id',
        'sub_category_id',
        'brand_id',
        'status',
        'is_public',
        'is_coordinate_suggest',
        'main_material_id',
        'sub_material_id', //materials_table →sub_materials_tableで紐づけしてるが必要？
        'washability_option',
        'purchased_date',
        'price',
        'purchased_at',
        'memo',
        'neck_circumference',
        'shoulder_width',
        'yuki_length',
        'chest_circumference',
        'waist',
        'inseam',
        'hip',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    //主素材
    public function mainMaterial()
    {
        return $this->belongsTo(Material::class, 'main_material_id');
    }

    //副素材
    public function subMaterial()
    {
        return $this->belongsTo(Material::class, 'sub_material_id');
    }

    //中間テーブル
    public function colors()
    {
        return $this->belongsToMany(Color::class, 'item_colors')->withTimestamps();
    }

    //中間テーブル
    public function seasons()
    {
        return $this->belongsToMany(Season::class, 'item_seasons')->withTimestamps();
    }

    //中間テーブル
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'item_tags')->withTimestamps();
    }

    public function scopeOfUser($query, $userId)
    {
        return $query->with(['image', 'category', 'brand'])
            ->where('user_id', $userId); //$queryはEloquent クエリビルダインスタンス
        //クエリ実行は paginate(), get()を最後につなげる

    }

    public function scopeCategory($query, $categoryId)
    {
        if (!empty($categoryId) && $categoryId !== '0') {
            $query->where('category_id', $categoryId);
        }
        return $query;
    }

    public function scopeStatus($query, $status)
    {
        if (!empty($status)) {
            return $query->where('status', $status);
        }
        return $query;
    }
    public function scopeSortOrder($query, $sortOrder)
    {
        switch ($sortOrder) {
            case 'purchased_date_desc':
                return $query->orderBy('purchased_date', 'desc');
            case 'purchased_date_asc':
                return $query->orderBy('purchased_date', 'asc');
            case 'created_at_asc':
                return $query->orderBy('created_at', 'asc');
            default:
                return $query->orderBy('created_at', 'desc');
        }
    }
}
