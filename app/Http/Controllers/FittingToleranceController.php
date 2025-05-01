<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\FittingTolerance;
use App\Services\FittingToleranceService;

class FittingToleranceController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fittingTolerances = FittingTolerance::where('user_id', Auth::id())->get();
        // dd($fittingTolerances);
        // foreach($fittingTolerances as $fittingTolerance) {
        //     dd($fittingTolerance);
        // }

        $userId = Auth::id();

        return view('fittingtolerance.index', compact('fittingTolerances', 'userId'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit()
    {
        $fittingTolerances = FittingTolerance::where('user_id', Auth::id())->get();
        $userId = Auth::id();

        return view('fittingtolerance.edit',     [
            'fittingTolerances' => $fittingTolerances,
            'userId' => $userId,
            'defaultValues' => FittingToleranceService::getDefaultValues(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // 通常バリデーションを作成
        $validator = Validator::make($request->all(), FittingToleranceService::getValidationRules());

        // カスタムバリデーションを追加
        $validator->after(function ($validator) use ($request) {
            $tolerances = $request->input('tolerances');

            foreach ($tolerances as $key => $values) {
                if (isset($values['min_value'], $values['max_value'])) {
                    if ($values['min_value'] > $values['max_value']) {
                        $validator->errors()->add("tolerances.$key.min_value", '下限値は上限値以下に設定してください。');
                        $validator->errors()->add("tolerances.$key.max_value", '上限値は下限値以上に設定してください。');
                    }
                }
            }
        });

        // バリデーションエラーがあればリダイレクト
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $userId = Auth::id();
        $requestedTolerances = $request->input('tolerances'); //入力されたparamを取得

        foreach ($requestedTolerances as $key => $requestedValues) {
            // キーを body_part と tolerance_level に分割
            [$bodyPart, $toleranceLevel] = explode('-', $key); // $keyを _ で分割する

            // データを取得して更新
            $tolerance = FittingTolerance::where('user_id', $userId)
                ->where('body_part', $bodyPart) // 引数（カラム、値）
                ->where('tolerance_level', $toleranceLevel)
                ->first();

            if ($tolerance) {
                $tolerance->min_value = $requestedValues['min_value'];
                $tolerance->max_value = $requestedValues['max_value'];
                $tolerance->save();
            } else {
                return redirect()
                    ->route(Auth::user()->role === 'admin' ? 'admin.tolerance.index' : 'tolerance.index')
                    ->with([
                        'message' => '補正値情報が見つかりません。',
                        'status' => 'alert'
                    ]);
            }
        }

        $route = Auth::user()->role === 'admin' ? 'admin.tolerance.index' : 'tolerance.index';

        return redirect()
            ->route($route)
            ->with([
                'message' => '体格情報を更新しました。',
                'status' => 'info'
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
