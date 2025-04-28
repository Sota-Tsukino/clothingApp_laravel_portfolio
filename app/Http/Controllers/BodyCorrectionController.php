<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BodyCorrection;
use App\Models\BodyMeasurement;

class BodyCorrectionController extends Controller
{
    private array $fields = [
        'head_circumference',
        'neck_circumference',
        'shoulder_width',
        'yuki_length',
        'sleeve_length',
        'chest_circumference',
        'waist',
        'hip',
        'inseam',
        'foot_length',
        'foot_circumference',
    ];

    private function validationRules(): array
    {
        $rules = [];
        foreach ($this->fields as $field) {
            $rules[$field] = 'require|numeric|between:0,15';
        }
        return $rules;
    }

    public function edit(Request $request, string $id) {
        //セッションに体格情報IDを保持させ、補正値画面で戻るボタン押した際にこれをparamで渡す。
        if ($request->has('from_measurement_id')) {
            session(['from_measurement_id' => $request->input('from_measurement_id')]);
        }
        
        $bodyCorrection = BodyCorrection::Findorfail($id);
        $bodyMeasurement = bodyMeasurement::Findorfail($request->from_measurement_id);
        // dd($bodyMeasurement);

        return view('bodycorrection.edit', [
            // 'bodyMeasurement' => $bodyMeasurement,
            'fields' => $this->fields,
            'bodyCorrection' => $bodyCorrection,
            'bodyMeasurement' => $bodyMeasurement,
        ]);
    }
}
