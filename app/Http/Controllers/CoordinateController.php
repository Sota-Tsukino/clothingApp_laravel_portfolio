<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\SceneTag;
use App\Models\Coordinate;
use App\Rules\UserOwnItem;
use App\Services\ItemService;

class CoordinateController extends Controller
{
    public function create()
    {
        $userId = Auth::id();
        $sceneTags = SceneTag::all(); //マスタデータを取得

        //ユーザー登録済みの衣類アイテムを取得
        $items = ItemService::getAllItemsByUserId($userId);

        // dd($sceneTags, $items);
        return view('coordinate.create', [
            'sceneTags' => $sceneTags,
            'items' => $items,
        ]);
    }

    public function store(Request $request)
    {
        // itemsの中身がnull,空文字列などを除外した上でバリデーション
        $items = array_filter($request->input('items', []), fn($item) => !empty($item));
        $request->merge(['items' => $items]);

        $request->validate([
            'items' => 'required|array|min:2', //$request->items = []; 最低２つ登録必須
            'items.*' => ['integer', 'distinct', new UserOwnItem], //各item_idが重複しないこと
            'sceneTag_id' => 'integer|required|exists:scene_tags,id',
            'is_public' => 'boolean|required',// blade側の valueは0,1でOK（booleanにキャストされる）
            'is_favorite' => 'boolean|required',
            'memo' => 'string|nullable|max:50',
        ]);

        DB::transaction(function () use ($request) {
            $coordinate = Coordinate::create([
                'user_id' => Auth::id(),
                'scene_tag_id' => $request->sceneTag_id,
                'is_public' => $request->is_public,
                'is_favorite' => $request->is_favorite,
                'memo' => $request->memo,
            ]);

            // 衣類アイテム_コーデ（中間テーブル）にデータ挿入
            $coordinate->items()->attach($request->items); // items[]は複数選択された衣類IDの配列
        });

        return redirect()
            ->route(Auth::user()->role === 'admin' ? 'admin.coordinate.create' : 'coordinate.create')
            ->with([
                'message' => 'コーデを登録しました。',
                'status' => 'info'
            ]);
    }
}
