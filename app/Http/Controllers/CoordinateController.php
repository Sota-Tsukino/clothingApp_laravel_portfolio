<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SceneTag;
use App\Services\ItemService;

class CoordinateController extends Controller
{
    public function create()
    {
        $userId = Auth::id();
        $sceneTags = SceneTag::all();//マスタデータを取得

        //ユーザー登録済みの衣類アイテムを取得
        $items = ItemService::getAllItemsByUserId($userId);

        // dd($sceneTags, $items);
        return view('coordinate.create', [
            'sceneTags' => $sceneTags,
            'items' => $items,
        ]);
    }
}
