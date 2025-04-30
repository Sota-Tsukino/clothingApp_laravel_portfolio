<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\FittingTolerance;

class FittingToleranceController extends Controller
{
    private array $defaultValues = [
        'yuki_length-just' => [
            "min_value" => -1.5,
            "max_value" => 1.5
        ],
        'yuki_length-slight' => [
            "min_value" => -3.0,
            "max_value" => 3.0
        ],
        'yuki_length-long_or_short' => [
            "min_value" => -5.0,
            "max_value" => 5.0
        ],
        'neck_circumference-just' => [
            "min_value" => -0.5,
            "max_value" => 0.5
        ],
        'neck_circumference-slight' => [
            "min_value" => -1.0,
            "max_value" => 1.5
        ],
        'neck_circumference-long_or_short' => [
            "min_value" => -2.0,
            "max_value" => 2.5
        ],
        'chest_circumference-just' => [
            "min_value" => -1.5,
            "max_value" => 1.5
        ],
        'chest_circumference-slight' => [
            "min_value" => -3.0,
            "max_value" => 3.0
        ],
        'chest_circumference-long_or_short' => [
            "min_value" => -5.0,
            "max_value" => 5.0
        ],
        'waist-just' => [
            "min_value" => -1.0,
            "max_value" => 1.0
        ],
        'waist-slight' => [
            "min_value" => -2.5,
            "max_value" => 2.5
        ],
        'waist-long_or_short' => [
            "min_value" => -4.0,
            "max_value" => 4.0
        ],
        'inseam-just' => [
            "min_value" => -1.5,
            "max_value" => 1.5
        ],
        'inseam-slight' => [
            "min_value" => -3.0,
            "max_value" => 3.0
        ],
        'inseam-long_or_short' => [
            "min_value" => -5.0,
            "max_value" => 5.0
        ],
        'hip-just' => [
            "min_value" => -1.5,
            "max_value" => 1.5
        ],
        'hip-slight' => [
            "min_value" => -3.0,
            "max_value" => 3.0
        ],
        'hip-long_or_short' => [
            "min_value" => -5.0,
            "max_value" => 5.0
        ],
    ];

    private function validationRules(): array
    {
        $rules = [];
        foreach ($this->defaultValues as $key => $values) {
            // .記法でネストされたキーを指定する
            $rules["tolerances.$key.min_value"] = 'required|numeric|between:-10.0,10.0';
            $rules["tolerances.$key.max_value"] = 'required|numeric|between:-10.0,10.0';
        }
        return $rules;
    }


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
            'defaultValues' => $this->defaultValues,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        $request->validate($this->validationRules());

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
