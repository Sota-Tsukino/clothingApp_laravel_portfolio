<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BodyMeasurement;
use App\Models\BodyCorrection;
use App\Models\FittingTolerance;

class SizeCheckerController extends Controller
{
    public function index(Request $request)
    {

        //セッションに体格情報IDを保持させ、サイズチェッカー画面で戻るボタン押した際にこれをparamで渡す。
        if ($request->has('from_measurement_id')) {
            session(['from_measurement_id' => $request->input('from_measurement_id')]);
        }

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
        foreach($fields as $field) {
            $suitableSize[$field] = $bodyMeasurement->$field + $bodyCorrection->$field;
        }

        $userTolerance = [];
        foreach ($fittingTolerance as $tolerance) {
            $userTolerance[$tolerance->body_part][$tolerance->tolerance_level] = [
                'min_value' => $tolerance->min_value,
                'max_value' => $tolerance->max_value,
            ];
        }
        // dd($userTolerance);
        return view('sizechecker.index', compact('bodyMeasurement', 'suitableSize', 'fields', 'userTolerance'));
    }
}
