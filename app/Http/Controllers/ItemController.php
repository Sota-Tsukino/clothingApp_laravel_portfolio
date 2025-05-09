<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Tag;
use App\Models\Season;
use App\Models\Material;
use App\Models\BodyMeasurement;
use App\Models\BodyCorrection;
use App\Models\FittingTolerance;
use App\Models\Item;
use App\Models\Image;
use App\Services\ImageService;
use App\Services\SizeCheckerService;
use App\Services\BodyMeasurementService;
use App\Services\BodyCorrectionService;
use App\Services\FittingToleranceService;

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

        //with()の引数はmodels/Category.phpで定義したメソッド名を指定
        $categories = Category::with('subCategory')->get();

        //マスターテーブルより全データ取得
        $colors = Color::all();
        $brands = Brand::all();
        $tags = Tag::all();
        $seasons = Season::all();
        $materials = Material::all();

        //サイズチェッカーに必要な情報を取得
        $userId = Auth::id();
        $bodyMeasurement = BodyMeasurementService::getLatestForUser($userId);
        $bodyCorrection = BodyCorrectionService::getForUser($userId);
        $suitableSize = SizeCheckerService::getSuitableSize($bodyMeasurement, $bodyCorrection);
        $userTolerance = FittingToleranceService::getForUser($userId);
        $fields = SizeCheckerService::getFields();

        return view('item.create', compact('categories', 'colors', 'brands', 'tags', 'seasons', 'materials', 'bodyMeasurement', 'suitableSize', 'fields', 'userTolerance'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ItemRequest $request)
    {

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
                    'image_id' => isset($image) ? $image->id : null,
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
            }); //引数2で、transactionの回数を指定？
        } catch (Throwable $e) { // Exceptionの方がいい？
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
        //　with() modelで定義したリレーションのメソッド名
        $item = Item::with(['image', 'category', 'brand', 'mainMaterial', 'subMaterial', 'colors', 'seasons', 'tags'])->findOrFail($id);
        //参照する体格情報が、ログインユーザー所有のものか？を判定
        if ($item->user_id !== Auth::id()) {
            return redirect()
                ->route(Auth::user()->role === 'admin' ? 'admin.clothing-item.index' : 'measurement.index')
                ->with([
                    'message' => '他のユーザーの衣類情報は参照できません。',
                    'status' => 'alert'
                ]);
        }

        //サイズチェッカーに必要な情報を取得
        $userId = Auth::id();
        $bodyMeasurement = BodyMeasurementService::getLatestForUser($userId);
        $bodyCorrection = BodyCorrectionService::getForUser($userId);
        $suitableSize = SizeCheckerService::getSuitableSize($bodyMeasurement, $bodyCorrection);
        $userTolerance = FittingToleranceService::getForUser($userId);
        $fields = SizeCheckerService::getFields();

        //サイズチェッカー用で衣類サイズをJSに渡す変数
        $itemSize = SizeCheckerService::getItemSize($item);

        // dd($item);
        return view('item.show', [
            'item' => $item,
            'fields' => $fields,
            'suitableSize' => $suitableSize,
            'userTolerance' => $userTolerance,
            'itemSize' => $itemSize,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
