<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Item;
use App\Models\Image;
use App\Services\ImageService;
use App\Services\SizeCheckerService;
use App\Services\BodyMeasurementService;
use App\Services\BodyCorrectionService;
use App\Services\FittingToleranceService;
use App\Services\ItemService;
use Exception;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return 'item C index()';
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $userId = Auth::id();
        $formData = ItemService::getFormData($userId);

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
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(ItemService::getValidationRules());

        try {
            //items, images item_colors, item_tags, item_seasons tableに保存
            DB::transaction(function () use ($request) {
                $imageFile =  $request->file('file_name'); //input tag name='file_name'
                if ($imageFile) {
                    $fileNameToStore = ImageService::upload($imageFile, 'items');
                    $image = Image::create([
                        'user_id' => Auth::id(),
                        'file_name' => $fileNameToStore
                    ]);
                }

                $item = Item::create([
                    'user_id' => Auth::id(),
                    'image_id' => $image->id ?? null,
                    'category_id' => $request->category_id,
                    'sub_category_id' => $request->sub_category_id,
                    'brand_id' => $request->brand_id,
                    'status' => $request->status,
                    'is_public' => $request->is_public,
                    'is_coordinate_suggest' => $request->is_coordinate_suggest,
                    'main_material_id' => $request->main_material,
                    'sub_material_id' => $request->sub_material,
                    'washability_option' => $request->washability_option,
                    'purchased_date' => $request->purchased_date,
                    'price' => $request->price,
                    'purchased_at' => $request->purchased_at,
                    'memo' => $request->memo,
                    'neck_circumference' => $request->neck_circumference,
                    'shoulder_width' => $request->shoulder_width,
                    'yuki_length' => $request->yuki_length,
                    'chest_circumference' => $request->chest_circumference,
                    'waist' => $request->waist,
                    'inseam' => $request->inseam,
                    'hip' => $request->hip,
                ]);

                // 色の登録（中間テーブル）のデータ挿入
                $item->colors()->attach($request->colors); // color_idsは配列で送る（例：[1, 2, 3]）

                // タグの登録（中間テーブル）のデータ挿入
                $item->tags()->attach($request->tags);

                // 季節の登録（中間テーブル）のデータ挿入
                $item->seasons()->attach($request->seasons);
            });
        } catch (Throwable $e) {
            Log::error($e);
            throw $e;
        }

        return redirect()
            ->route(Auth::user()->role === 'admin' ? 'admin.clothing-item.create' : 'clothing-item.create')
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
            $item = ItemService::getItemById($id);
            ItemService::isUserOwn($item, $userId);

            //サイズチェッカーに必要な情報を取得
            $userId = Auth::id();
            $bodyMeasurement = BodyMeasurementService::getLatestForUser($userId);
            $bodyCorrection = BodyCorrectionService::getForUser($userId);
            $suitableSize = SizeCheckerService::getSuitableSize($bodyMeasurement, $bodyCorrection);
            $userTolerance = FittingToleranceService::getForUser($userId);
            $fields = SizeCheckerService::getFields();
        } catch (\Exception $e) {
            return redirect()
                ->route(Auth::user()->role === 'admin' ? 'admin.clothing-item.index' : 'measurement.index')
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
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $userId = Auth::id();
        try {
            $formDataWithItem = ItemService::getFormDataWithItem($id, $userId);
        } catch (\Exception $e) {
            return redirect()
                ->route(Auth::user()->role === 'admin' ? 'admin.clothing-item.index' : 'measurement.index')
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
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate(ItemService::getValidationRules(true));
        $userId = Auth::id();

        try {
            $item = ItemService::getItemById($id);
            ItemService::isUserOwn($item, $userId);

            $updatedItem = ItemService::saveItem($request->all(), $item);

            return redirect()
                ->route(Auth::user()->role === 'admin' ? 'admin.clothing-item.show' : 'clothing-item.show', $updatedItem)
                ->with(['message' => '衣類アイテムを更新しました。', 'status' => 'info']);

        } catch (Exception $e) {
            return redirect()
                ->route(Auth::user()->role === 'admin' ? 'admin.clothing-item.edit' : 'clothing-item.edit', $id)
                ->with(['message' => $e->getMessage(), 'status' => 'alert']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
