<?php

namespace App\Services;

use App\Models\Item;
use App\Services\BodyMeasurementService;
use App\Services\BodyCorrectionService;
use App\Services\FittingToleranceService;
use App\Services\SizeCheckerService;

class ItemService
{

    //リクエストデータの取得
    // public static function getFormData(int $userId): array
    // {
    //     return [
    //         'categories' => Category::with('subCategory')->get(),
    //         'colors' => Color::all(),
    //         'brands' => Brand::all(),
    //         'tags' => Tag::all(),
    //         'seasons' => Season::all(),
    //         'materials' => Material::all(),
    //         'bodyMeasurement' => BodyMeasurementService::getLatestForUser($userId),
    //         'bodyCorrection' => BodyCorrectionService::getForUser($userId),
    //         'suitableSize' => SizeCheckerService::getSuitableSize(
    //             BodyMeasurementService::getLatestForUser($userId),
    //             BodyCorrectionService::getForUser($userId)
    //         ),
    //         'userTolerance' => FittingToleranceService::getForUser($userId),
    //         'fields' => SizeCheckerService::getFields(),
    //     ];
    // }

    //アイテムの取得
    public static function getItemById($id)
    {
        //　with() modelで定義したリレーションのメソッド名
        return Item::with(['image', 'category', 'brand', 'mainMaterial', 'subMaterial', 'colors', 'seasons', 'tags'])->findOrFail($id);
    }

    //アイテムがログインユーザー所有か判定
    public static function isUserOwn($item, $userId)
    {
        if ($item->user_id !== $userId) {
            return redirect()
                ->route(Auth::user()->role === 'admin' ? 'admin.clothing-item.index' : 'measurement.index')
                ->with([
                    'message' => '他のユーザーの衣類情報は参照できません。',
                    'status' => 'alert'
                ]);
        }
    }

    //Item一覧を取得(index画面用)
    public static function getAllItemsByUserId($userId) {}
}
