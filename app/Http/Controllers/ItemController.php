<?php

namespace App\Http\Controllers;

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

        $bodyMeasurement = BodyMeasurement::where('user_id', Auth::id())
            ->orderBy('measured_at', 'desc')->firstOrFail();
        // dd(
        //     $tags,
        //     $seasons,
        //     $materials,
        // );


        //要リファクタリング（サイズチェッカーと同じ処理）
        $bodyCorrection = BodyCorrection::findOrFail(Auth::id());
        $fittingTolerance = FittingTolerance::where('user_id', Auth::id())->get();

        $fields = [
            'neck_circumference',
            'shoulder_width',
            'yuki_length',
            'chest_circumference',
            'waist',
            'inseam',
            'hip',
        ];
        $suitableSize = [];
        foreach ($fields as $field) {
            $suitableSize[$field] = $bodyMeasurement->$field + $bodyCorrection->$field;
        }

        $userTolerance = [];
        foreach ($fittingTolerance as $tolerance) {
            $userTolerance[$tolerance->body_part][$tolerance->tolerance_level] = [
                'min_value' => $tolerance->min_value,
                'max_value' => $tolerance->max_value,
            ];
        }

        return view('item.create', compact('categories', 'colors', 'brands', 'tags', 'seasons', 'materials', 'bodyMeasurement', 'suitableSize', 'fields', 'userTolerance'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
             //画像であるか、拡張子が指定の物か、画像サイズが最大4MBまで
            'file_name' => 'required|image|mimes:jpg,jpeg,png|mimetypes:image/jpeg,image/png|max:4096',
            'category_id' => 'integer|required|exists:categories,id',
            'sub_category_id' => 'integer|required|exists:sub_categories,id',
            'brand_id' => 'integer|required|exists:brands,id',
            'colors' => 'required|array',
            'colors.*' => 'integer|exists:colors,id',
            'status' => [Rule::in(['owned', 'cleaning', 'discarded'])],
            'is_public' => 'integer|required',
            'is_coordinate_suggest' => 'integer|required|between:0,1',
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
            'neck_circumference' => 'nullable|numeric|between:0,999.0',
            'shoulder_width' => 'nullable|numeric|between:0,999.0',
            'yuki_length' => 'nullable|numeric|between:0,999.0',
            'chest_circumference' => 'nullable|numeric|between:0,999.0',
            'waist' => 'nullable|numeric|between:0,999.0',
            'inseam' => 'nullable|numeric|between:0,999.0',
            'hip' => 'nullable|numeric|between:0,999.0',
        ]);
        // dd($request, $request->file('file_name'));

        try {
            //items, images item_colors, item_tags, item_seasons tableに保存
            DB::transaction(function () use ($request) {
                $imageFile =  $request->file('file_name');//input tag name='file_name'
                if ($imageFile) {
                    $fileNameToStore = ImageService::upload($imageFile, 'items');
                    $image = Image::create([
                        'user_id' => Auth::id(),
                        'file_name' => $fileNameToStore
                    ]);
                }

                // dd($request);
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
            });//引数2で、transactionの回数を指定？
        } catch (Throwable $e) {// Exceptionの方がいい？
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
        $item = Item::with(['image','category', 'brand', 'mainMaterial', 'subMaterial', 'colors', 'seasons', 'tags'])->findOrFail($id);
        //参照する体格情報が、ログインユーザー所有のものか？を判定
        if ($item->user_id !== Auth::id()) {
        return redirect()
            ->route(Auth::user()->role === 'admin' ? 'admin.clothing-item.index' : 'measurement.index')
            ->with([
                'message' => '他のユーザーの衣類情報は参照できません。',
                'status' => 'alert'
            ]);
        }

        //要リファクタリング（サイズチェッカーと同じ処理）
        $bodyMeasurement = BodyMeasurement::where('user_id', Auth::id())
        ->orderBy('measured_at', 'desc')->firstOrFail();
        $bodyCorrection = BodyCorrection::findOrFail(Auth::id());
        $fittingTolerance = FittingTolerance::where('user_id', Auth::id())->get();

        $fields = [
            'neck_circumference',
            'shoulder_width',
            'yuki_length',
            'chest_circumference',
            'waist',
            'inseam',
            'hip',
        ];
        $suitableSize = [];
        foreach ($fields as $field) {
            $suitableSize[$field] = $bodyMeasurement->$field + $bodyCorrection->$field;
        }

        $userTolerance = [];
        foreach ($fittingTolerance as $tolerance) {
            $userTolerance[$tolerance->body_part][$tolerance->tolerance_level] = [
                'min_value' => $tolerance->min_value,
                'max_value' => $tolerance->max_value,
            ];
        }

        //サイズチェッカー用で衣類サイズをJSに渡す変数
        $itemSize = [];
        foreach($fields as $field) {
            $itemSize[$field] = $item[$field];
        }

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
