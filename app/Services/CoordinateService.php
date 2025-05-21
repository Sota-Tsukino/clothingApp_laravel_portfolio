<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Exception;
use App\Rules\UserOwnItem;
use App\Models\Coordinate;


class CoordinateService
{
    public static function getValidationRules(bool $isUpdate = false): array
    {
        $rules = [
            'items' => 'required|array|min:2', //$request->items = []; 最低２つ登録必須
            'items.*' => ['integer', 'distinct', new UserOwnItem], //各item_idが重複しないこと
            'sceneTag_id' => 'integer|required|exists:scene_tags,id',
            'is_public' => 'boolean|required', // blade側の valueは0,1でOK（booleanにキャストされる）
            'is_favorite' => 'boolean|required',
            'memo' => 'string|nullable|max:50',
        ];

        return $rules;
    }

    public static function getCoordinateById($id)
    {
        //Itemモデルにimage()リレーションが定義されていること
        return  Coordinate::with(['items.image', 'sceneTag'])->findOrFail($id);
    }

    public static function isUserOwn($coordinate, $userId): void
    {
        if ($coordinate->user_id !== $userId) {
            throw new Exception('他のユーザーのコーデ情報は参照できません。');
        }
    }

    public static function saveCoordinate(array $data, ?Coordinate $coordinate = null): Coordinate
    {

        return DB::transaction(function () use ($data, $coordinate) {

            $coordinateData = [
                'user_id' => Auth::id(),
                'scene_tag_id' => $data['sceneTag_id'],
                'is_public' => $data['is_public'],
                'is_favorite' => $data['is_favorite'],
                'memo' => $data['memo'] ?? null,
            ];


            if ($coordinate) {
                $coordinate->update($coordinateData);
            } else {
                $coordinate = Coordinate::create($coordinateData);
            }

            // 中間テーブル（多対多）の更新（null配列に注意）
            $coordinate->items()->sync($data['items'] ?? []);

            return $coordinate;
        });
    }

    public static function getAllCoordinateByUserId($userId, bool $is_paginate = false)
    {
        $coordinates = Coordinate::with(['items.image', 'sceneTag'])
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc');

        return $is_paginate ?  $coordinates->paginate(\Constant::DEFAULT_PAGINATION) : $coordinates->get();
    }

    public static function searchCoordinateByUser($userId, $filters = [])
    {
        return Coordinate::ofUser($userId)
            ->isFavorite($filters['is_favorite'] ?? null)
            ->sortOrder($filters['sort'] ?? null)
            ->paginate($filters['pagination'] ?? \Constant::DEFAULT_PAGINATION)
            ->appends($filters);
    }
}
