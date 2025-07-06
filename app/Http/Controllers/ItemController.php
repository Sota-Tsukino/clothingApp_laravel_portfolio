<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\SizeCheckerService;
use App\Services\BodyMeasurementService;
use App\Services\BodyCorrectionService;
use App\Services\FittingToleranceService;
use App\Services\ItemService;
use Illuminate\Support\Facades\Storage;
use Exception;
use Illuminate\Validation\Rule;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userId = Auth::id();
        $params = $request->only(['category', 'status', 'sort', 'pagination']);

        //getにparamが含まれる（検索）場合、通常表示の場合
        $items = !empty(array_filter($params)) // array_filter()は値が空でない要素のみ返す
            ? ItemService::searchItemsByUser($userId, $params)
            : ItemService::getAllItemsByUserId($userId, true);
        $categories = Category::with('subCategory')->get();

        return view('item.index', [
            'items' => $items,
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $userId = Auth::id();
        if (!BodyMeasurementService::hasBodyMeasurement($userId)) {
            return redirect()
                ->route(Auth::user()->role === 'admin' ? 'admin.measurement.create' : 'measurement.create')
                ->with([
                    'message' => 'サイズチェッカー機能を利用するため、体格情報を登録してください。',
                    'status' => 'alert'
                ]);
        }
        $formData = ItemService::getFormData($userId);
        $priorityMap = SizeCheckerService::getPriorityMap();
        $guides = SizeCheckerService::getGuide();

        return view('item.create', [
            'categories' => $formData['categories'],
            'colors' => $formData['colors'],
            'brands' => $formData['brands'],
            'tags' => $formData['tags'],
            'seasons' => $formData['seasons'],
            'materials' => $formData['materials'],
            'bodyMeasurement' => $formData['bodyMeasurement'],
            'suitableSize' => $formData['suitableSize'],
            'fields' => $formData['fields'],
            'userTolerance' => $formData['userTolerance'],
            'priorityMap' => $priorityMap,
            'guides' => $guides,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        $request->validate(ItemService::getValidationRules());

        try {
            $item = ItemService::saveItem($request->all());
        } catch (Exception $e) {
            return redirect()
                ->route(Auth::user()->role === 'admin' ? 'admin.clothing-item.create' : 'clothing-item.create')
                ->with(['message' => $e->getMessage(), 'status' => 'alert']);
        }

        return redirect()
            ->route(Auth::user()->role === 'admin' ? 'admin.clothing-item.show' : 'clothing-item.show', $item->id)
            ->with([
                'message' => '衣類アイテムを登録しました。',
                'status' => 'info'
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $userId = Auth::id();
            if (!BodyMeasurementService::hasBodyMeasurement($userId)) {
                return redirect()
                    ->route(Auth::user()->role === 'admin' ? 'admin.measurement.create' : 'measurement.create')
                    ->with([
                        'message' => 'サイズチェッカー機能を利用するため、体格情報を登録してください。',
                        'status' => 'alert'
                    ]);
            }
            $item = ItemService::getItemById($id);
            ItemService::isUserOwn($item, $userId);

            //サイズチェッカーに必要な情報を取得
            $bodyMeasurement = BodyMeasurementService::getLatestForUser($userId);
            $bodyCorrection = BodyCorrectionService::getForUser($userId);
            $suitableSize = SizeCheckerService::getSuitableSize($bodyMeasurement, $bodyCorrection);
            $userTolerance = FittingToleranceService::getForUser($userId);
            $fields = SizeCheckerService::getFields();
            $priorityMap = SizeCheckerService::getPriorityMap();
            $guides = SizeCheckerService::getGuide();
        } catch (\Exception $e) {
            return redirect()
                ->route(Auth::user()->role === 'admin' ? 'admin.clothing-item.index' : 'clothing-item.index')
                ->with([
                    'message' => $e->getMessage(),
                    'status' => 'alert'
                ]);
        }

        return view('item.show', [
            'item' => $item,
            'fields' => $fields,
            'suitableSize' => $suitableSize,
            'userTolerance' => $userTolerance,
            'priorityMap' => $priorityMap,
            'guides' => $guides,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $userId = Auth::id();
        if (!BodyMeasurementService::hasBodyMeasurement($userId)) {
            return redirect()
                ->route(Auth::user()->role === 'admin' ? 'admin.measurement.create' : 'measurement.create')
                ->with([
                    'message' => 'サイズチェッカー機能を利用するため、体格情報を登録してください。',
                    'status' => 'alert'
                ]);
        }
        try {
            $formDataWithItem = ItemService::getFormDataWithItem($id, $userId);
            $priorityMap = SizeCheckerService::getPriorityMap();
            $guides = SizeCheckerService::getGuide();
        } catch (\Exception $e) {
            return redirect()
                ->route(Auth::user()->role === 'admin' ? 'admin.clothing-item.index' : 'clothing-item.index')
                ->with([
                    'message' => $e->getMessage(),
                    'status' => 'alert'
                ]);
        }

        // dd($item->colors);

        return view('item.edit', [
            'categories' => $formDataWithItem['categories'],
            'colors' => $formDataWithItem['colors'],
            'brands' => $formDataWithItem['brands'],
            'tags' => $formDataWithItem['tags'],
            'seasons' => $formDataWithItem['seasons'],
            'materials' => $formDataWithItem['materials'],
            'item' => $formDataWithItem['item'],
            'bodyMeasurement' => $formDataWithItem['bodyMeasurement'],
            'suitableSize' => $formDataWithItem['suitableSize'],
            'fields' => $formDataWithItem['fields'],
            'userTolerance' => $formDataWithItem['userTolerance'],
            'priorityMap' => $priorityMap,
            'guides' => $guides,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request);
        $request->validate(ItemService::getValidationRules(true));
        $userId = Auth::id();

        try {
            $item = ItemService::getItemById($id);
            ItemService::isUserOwn($item, $userId);

            $item = ItemService::saveItem($request->all(), $item);

            return redirect()
                ->route(Auth::user()->role === 'admin' ? 'admin.clothing-item.show' : 'clothing-item.show', $item)
                ->with(['message' => '衣類アイテムを更新しました。', 'status' => 'info']);
        } catch (Exception $e) {
            return redirect()
                ->route(Auth::user()->role === 'admin' ? 'admin.clothing-item.edit' : 'clothing-item.edit', $id)
                ->with(['message' => $e->getMessage(), 'status' => 'alert']);
        }
    }

    public function switchStatus(Request $request, string $id)
    {
        $request->validate(['status' => [Rule::in(['owned', 'cleaning', 'discarded'])]]);
        $userId = Auth::id();

        try {
            $item = ItemService::getItemById($id);
            ItemService::isUserOwn($item, $userId);

            $item = ItemService::saveStatus($item);

            return redirect()
                ->route(Auth::user()->role === 'admin' ? 'admin.clothing-item.index' : 'clothing-item.index', $item)
                ->with(['message' => 'ステータスを更新しました', 'status' => 'info']);
        } catch (Exception $e) {
            return redirect()
                ->route(Auth::user()->role === 'admin' ? 'admin.clothing-item.index' : 'clothing-item.index')
                ->with(['message' => $e->getMessage(), 'status' => 'alert']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $userId = Auth::id();

        try {
            $item = ItemService::getItemById($id);
            ItemService::isUserOwn($item, $userId);
            ItemService::isUsedInCoordinates($item->id, $userId);

            if (!empty($item->image)) {
                $filePath = $item->image->file_name;

                //イメージテーブル削除
                $item->image->delete();

                //イメージ画像削除（サーバー内）
                Storage::delete('public/items/' . $filePath);
            }

            //衣類アイテムを削除
            $item->delete();

            return redirect()
                ->route(Auth::user()->role === 'admin' ? 'admin.clothing-item.index' : 'clothing-item.index')
                ->with([
                    'message' => 'アイテム情報を削除しました。',
                    'status' => 'info'
                ]);
        } catch (Exception $e) {
            return redirect()
                ->route(Auth::user()->role === 'admin' ? 'admin.clothing-item.index' : 'clothing-item.index')
                ->with([
                    'message' => '削除処理に失敗しました: ' . $e->getMessage(),
                    'status' => 'alert'
                ]);
        }
    }
}
