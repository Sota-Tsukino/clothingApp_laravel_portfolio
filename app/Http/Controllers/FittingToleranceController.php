<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\FittingTolerance;

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

        return view('fittingtolerance.edit', compact('fittingTolerances', 'userId'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $userId = Auth::id();
        $RequestedTolerances = $request->input('tolerances'); //入力されたparamを取得
        // dd($RequestedTolerances);

        foreach ($RequestedTolerances as $key => $RequestedValues) {
            // キーを body_part と tolerance_level に分割
            [$bodyPart, $toleranceLevel] = explode('-', $key); // $keyを _ で分割する

            // データを取得して更新
            $tolerance = FittingTolerance::where('user_id', $userId)
                ->where('body_part', $bodyPart) // カラム、データ
                ->where('tolerance_level', $toleranceLevel)
                ->first();

            if ($tolerance) {
                $tolerance->min_value = $RequestedValues['min_value'];
                $tolerance->max_value = $RequestedValues['max_value'];
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

        return redirect()
            ->route(Auth::user()->role === 'admin' ? 'admin.tolerance.index' : 'tolerance.index')
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
