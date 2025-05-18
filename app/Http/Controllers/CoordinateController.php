<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SceneTag;
use App\Models\Coordinate;
use App\Services\ItemService;
use App\Services\CoordinateService;
use Exception;


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

        $request->validate(CoordinateService::getValidationRules());

        try {
            $coordinate = CoordinateService::saveCoordinate($request->all());
        } catch (Exception $e) {
            return redirect()
                ->route(Auth::user()->role === 'admin' ? 'admin.coordinate.create' : 'coordinate.create')
                ->with(['message' => $e->getMessage(), 'status' => 'alert']);
        }

        return redirect()
            ->route(Auth::user()->role === 'admin' ? 'admin.coordinate.show' : 'coordinate.show', $coordinate->id)
            ->with([
                'message' => 'コーデを登録しました。',
                'status' => 'info'
            ]);
    }

    public function show(string $id)
    {
        $userId = Auth::id();

        try {
            $coordinate = CoordinateService::getCoordinateById($id);
            CoordinateService::isUserOwn($coordinate, $userId);
        } catch (Exception $e) {
            return redirect() //indexは未実装なので暫定でcreateにリダイレクト
                ->route(Auth::user()->role === 'admin' ? 'admin.coordinate.create' : 'coordinate.create')
                ->with([
                    'message' => $e->getMessage(),
                    'status' => 'alert'
                ]);
        }

        return view('coordinate.show', [
            'coordinate' => $coordinate,
        ]);
    }

    public function edit(string $id)
    {
        $userId = Auth::id();
        try {
            $coordinate = CoordinateService::getCoordinateById($id);
            CoordinateService::isUserOwn($coordinate, $userId);

            //ユーザー登録済みの衣類アイテムを取得
            $items = ItemService::getAllItemsByUserId($userId);
            $sceneTags = SceneTag::all(); //マスタデータを取得

        } catch (Exception $e) {
            return redirect()
                ->route(Auth::user()->role === 'admin' ? 'admin.coordinate.index' : 'coordinate.index')
                ->with([
                    'message' => $e->getMessage(),
                    'status' => 'alert'
                ]);
        }

        return view('coordinate.edit', [
            'coordinate' => $coordinate,
            'sceneTags' => $sceneTags,
            'items' => $items,
        ]);
    }

    public function update(Request $request, string $id)
    {
        // itemsの中身がnull,空文字列などを除外した上でバリデーション
        $items = array_filter($request->input('items', []), fn($item) => !empty($item));
        $request->merge(['items' => $items]);
        $request->validate(CoordinateService::getValidationRules());

        try {
            $coordinate = Coordinate::findOrFail($id);
            $userId = Auth::id();
            CoordinateService::isUserOwn($coordinate, $userId);
            CoordinateService::saveCoordinate($request->all(), $coordinate);
        } catch (Exception $e) {
            return redirect()
                ->route(Auth::user()->role === 'admin' ? 'admin.coordinate.edit' : 'coordinate.edit', $id)
                ->with(['message' => $e->getMessage(), 'status' => 'alert']);
        }

        return redirect()
            ->route(Auth::user()->role === 'admin' ? 'admin.coordinate.show' : 'coordinate.show', ['coordinate' => $id])
            ->with(['message' => 'コーデを更新しました。', 'status' => 'info']);
    }
}
