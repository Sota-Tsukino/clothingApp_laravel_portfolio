<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Exception;
use App\Models\Item;
use App\Models\Image;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Tag;
use App\Models\Season;
use App\Models\Material;
use App\Models\Coordinate;
use App\Services\BodyMeasurementService;
use App\Services\BodyCorrectionService;
use App\Services\FittingToleranceService;
use App\Services\SizeCheckerService;
use App\Services\ImageService;


class ItemService
{
    public static function getValidationRules(bool $isUpdate = false): array
    {
        $rules = [
            'category_id' => 'integer|required|exists:categories,id',
            'sub_category_id' => 'integer|required|exists:sub_categories,id',
            'brand_id' => 'integer|required|exists:brands,id',
            'colors' => 'required|array',
            'colors.*' => 'integer|exists:colors,id',
            'status' => [Rule::in(['owned', 'cleaning', 'discarded'])],
            'is_public' => 'integer|required',
            'is_item_suggest' => 'integer|required|between:0,1',
            'tags' => 'nullable|array',
            'tags.*' => 'integer|exists:tags,id',
            'seasons' => 'nullable|array',
            'seasons.*' => 'integer|exists:seasons,id',
            'main_material' => 'nullable|integer|exists:materials,id',
            'sub_material' => 'nullable|integer|exists:materials,id',
            'washability_option' => [Rule::in(['washable_machine', 'washable_hand', 'not_washable']), 'nullable'],
            'purchased_at' => 'nullable|string|max:20',
            'price' => 'integer|nullable',
            'memo' => 'string|nullable|max:50',
        ];

        foreach (SizeCheckerService::getFields() as $field) {
            $rules[$field] = 'nullable|numeric|between:0,999.0';
        }

        //画像であるか、拡張子が指定の物か、画像サイズが最大4MBまで
        $imageRule = 'image|mimes:jpg,jpeg,png|mimetypes:image/jpeg,image/png|max:4096';

        //store(),update()でvalidationルール切り替え
        if ($isUpdate) {
            $rules['file_name'] = 'nullable|' . $imageRule;
        } else { // store()
            $rules['file_name'] = 'required|' . $imageRule;
        }

        return $rules;
    }
    // フォームデータの取得
    public static function getFormData(int $userId): array
    {
        $bodyMeasurement = BodyMeasurementService::getLatestForUser($userId);
        $bodyCorrection = BodyCorrectionService::getForUser($userId);
        return [
            'categories' => Category::with('subCategory')->get(), //with()の引数はmodels/Category.phpで定義したメソッド名を指定
            'colors' => Color::all(),
            'brands' => Brand::all(),
            'tags' => Tag::all(),
            'seasons' => Season::all(),
            'materials' => Material::all(),
            //サイズチェッカーに必要な情報を取得
            'bodyMeasurement' => BodyMeasurementService::getLatestForUser($userId),
            'bodyCorrection' => BodyCorrectionService::getForUser($userId),
            'suitableSize' => SizeCheckerService::getSuitableSize($bodyMeasurement, $bodyCorrection),
            'userTolerance' => FittingToleranceService::getForUser($userId),
            'fields' => SizeCheckerService::getFields(),
        ];
    }

    public static function getFormDataWithItem(int $itemId, int $userId): array
    {
        $formData = self::getFormData($userId);
        $item = self::getItemById($itemId);
        self::isUserOwn($item, $userId);

        $formData['item'] = $item;
        return $formData;
    }


    //アイテムの取得
    public static function getItemById($id)
    {
        //　with() modelで定義したリレーションのメソッド名
        return Item::with(['image', 'category', 'brand', 'mainMaterial', 'subMaterial', 'colors', 'seasons', 'tags'])->findOrFail($id);
    }

    //アイテムがログインユーザー所有か判定
    public static function isUserOwn($item, $userId): void
    {
        if ($item->user_id !== $userId) {
            throw new Exception('他のユーザーの衣類情報は参照できません。');
        }
    }

    public static function isUsedInCoordinates($itemId, $userId)
    {
        //中間テーブル coordinate_itemを使ってクエリで判定
        $used = Coordinate::where('user_id', $userId)
            ->whereHas('items', fn($q) => $q->where('items.id', $itemId)) // itemsはリレーションメソッド名
            ->exists();

        if ($used) {
            throw new Exception('コーデに使用されている為、この衣類アイテムは削除できません。');
        }
    }


    public static function saveItem(array $data, ?Item $item = null): Item
    {
        return DB::transaction(function () use ($data, $item) {
            $image = null;

            // 新しい画像があればアップロードしてDB登録
            if (isset($data['file_name']) && $data['file_name'] instanceof \Illuminate\Http\UploadedFile) {
                $fileName = ImageService::upload($data['file_name'], 'items');

                if ($item && $item->image) { //既存アイテムなら更新する
                    //サーバーのファイル削除
                    Storage::delete('public/items/' . $item->image->file_name);
                    // 画像情報を update（file_name だけを更新）
                    $item->image->update([
                        'file_name' => $fileName,
                    ]);

                    $image = $item->image;
                } else {  // アイテム新規作成
                    $image = Image::create([
                        'user_id' => Auth::id(),
                        'file_name' => $fileName,
                    ]);

                    if (!$image || !$image->id) {
                        throw new Exception('画像の登録に失敗しました。');
                    }
                }
            }


            $itemData = [
                'user_id' => Auth::id(),
                'image_id' => $image->id ?? ($item->image_id ?? null), //画像が新規登録 or 既存アイテムのimage_idか？
                'category_id' => $data['category_id'],
                'sub_category_id' => $data['sub_category_id'],
                'brand_id' => $data['brand_id'],
                'status' => $data['status'],
                'is_public' => $data['is_public'],
                'is_item_suggest' => $data['is_item_suggest'],
                'main_material_id' => $data['main_material'] ?? null,
                'sub_material_id' => $data['sub_material'] ?? null,
                'washability_option' => $data['washability_option'] ?? null,
                'purchased_date' => $data['purchased_date'] ?? null,
                'price' => $data['price'] ?? null,
                'purchased_at' => $data['purchased_at'] ?? null,
                'memo' => $data['memo'] ?? null,
                'neck_circumference' => $data['neck_circumference'] ?? null,
                'shoulder_width' => $data['shoulder_width'] ?? null,
                'yuki_length' => $data['yuki_length'] ?? null,
                'chest_circumference' => $data['chest_circumference'] ?? null,
                'waist' => $data['waist'] ?? null,
                'inseam' => $data['inseam'] ?? null,
                'hip' => $data['hip'] ?? null,
            ];


            if ($item) {
                $item->update($itemData);
            } else {
                $item = Item::create($itemData);
            }

            // 中間テーブル（多対多）の更新（null配列に注意）
            //attach()：既存のデータに追加する（重複しても追加してしまう）→store()で使う
            //sync()：既存の中間テーブルのデータを一旦全削除し、再登録する（クリーンな更新）→update()で使う
            // dd($item);
            $item->colors()->sync($data['colors'] ?? []);
            $item->tags()->sync($data['tags'] ?? []);
            $item->seasons()->sync($data['seasons'] ?? []);

            return $item;
        });
    }

    public static function getAllItemsByUserId($userId, bool $is_paginate = false)
    {
        $items = Item::with(['image', 'category', 'brand', 'mainMaterial', 'subMaterial', 'colors', 'seasons', 'tags'])
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc');

        return $is_paginate ?  $items->paginate(\Constant::DEFAULT_PAGINATION) : $items->get();
    }

    public static function searchItemsByUser($userId, $filters = [])
    {
        return Item::ofUser($userId)
            ->category($filters['category'] ?? null)
            ->status($filters['status'] ?? null)
            ->sortOrder($filters['sort'] ?? null)
            ->paginate($filters['pagination'] ?? \Constant::DEFAULT_PAGINATION)
            ->appends($filters);
    }

    public static function getRecommendedItems(array $subCategoryIds, $userId)
    {
        if (empty($subCategoryIds)) {
            return null;
        }
        $item = Item::with(['image', 'category', 'brand', 'mainMaterial', 'subMaterial', 'colors', 'seasons', 'tags'])
            ->where('user_id', $userId)
            ->whereIn('sub_category_id', $subCategoryIds)
            ->inRandomOrder() //ランダム順に並び替え
            ->first(); // 最初の要素を取得

        return $item;
    }
}
