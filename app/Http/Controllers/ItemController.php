<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Tag;
use App\Models\Season;
use App\Models\Material;
use App\Models\BodyMeasurement;
use App\Models\BodyCorrection;
use App\Models\FittingTolerance;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        dd($request);//image file, colors, tags multi select対応未完了
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
