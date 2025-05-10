<?php

namespace App\Services;

use App\Models\Item;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Tag;
use App\Models\Season;
use App\Models\Material;
use App\Services\BodyMeasurementService;
use App\Services\BodyCorrectionService;
use App\Services\FittingToleranceService;
use App\Services\SizeCheckerService;

class ItemService
{
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
            throw new \Exception('他のユーザーの衣類情報は参照できません。');
        }
    }

    //Item一覧を取得(index画面用)
    public static function getAllItemsByUserId($userId) {}
}
