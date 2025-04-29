<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BodyCorrection;
use App\Models\BodyMeasurement;

class BodyCorrectionController extends Controller
{
    private array $fieldsDefaultValues = [
        'head_circumference' => 2.0,
        'neck_circumference' => 2.0,
        'shoulder_width' => 2.0,
        'chest_circumference' => 3.0,
        'waist' => 2.0,
        'hip' => 2.0,
        'sleeve_length' => 0.0,
        'yuki_length' => 0.0,
        'inseam' => 0.0,
        'foot_length' => 1.0,
        'foot_circumference' => 0.0,
    ];

    private function validationRules(): array
    {
        $rules = [];
        $fieldKeys = array_keys($this->fieldsDefaultValues);
        foreach ($fieldKeys as $field) {
            $rules[$field] = 'numeric|between:0,9';
        }
        return $rules;
    }

    public function edit(Request $request, string $id)
    {
        $fieldKeys = array_keys($this->fieldsDefaultValues);//keyのみ取り出して配列に格納

        //セッションに体格情報IDを保持させ、補正値画面で戻るボタン押した際にこれをparamで渡す。
        if ($request->has('from_measurement_id')) {
            session(['from_measurement_id' => $request->input('from_measurement_id')]);
        }

        $bodyCorrection = BodyCorrection::findOrFail($id);
        //参照する体格情報が、ログインユーザー所有のものか？を判定
        if ($bodyCorrection->user_id !== Auth::id()) {
            return redirect()
                ->route(Auth::user()->role === 'admin' ? 'admin.measurement.index' : 'measurement.index')
                ->with([
                    'message' => '他のユーザーの体格補正値は参照できません。',
                    'status' => 'alert'
                ]);
        }
        $bodyMeasurement = BodyMeasurement::findOrFail($request->from_measurement_id);
        //参照する体格情報が、ログインユーザー所有のものか？を判定
        if ($bodyMeasurement->user_id !== Auth::id()) {
            return redirect()
                ->route(Auth::user()->role === 'admin' ? 'admin.measurement.index' : 'measurement.index')
                ->with([
                    'message' => '他のユーザーの体格情報は参照できません。',
                    'status' => 'alert'
                ]);
        }

        return view('bodycorrection.edit', [
            'fields' => $fieldKeys,
            'bodyCorrection' => $bodyCorrection,
            'bodyMeasurement' => $bodyMeasurement,
            'defaultValues' => $this->fieldsDefaultValues,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate($this->validationRules());

        if ($request->has('from_measurement_id')) {
            session(['from_measurement_id' => $request->input('from_measurement_id')]);
        }

        $bodyCorrection = BodyCorrection::findOrFail($id);

        $fieldKeys = array_keys($this->fieldsDefaultValues);
        $bodyCorrection->fill($request->only($fieldKeys))->save(); //リファクタリング

        //フォーム送信(POST/PUT) → リダイレクト(302) → GETページ表示
        // viewではなくredirect()->route)を使う
        return redirect()
            ->route(Auth::user()->role === 'admin' ? 'admin.measurement.show' : 'measurement.show', ['measurement' => $request->from_measurement_id])
            ->with([
                'message' => '補正値を更新しました。',
                'status' => 'info'
            ]);
    }
}
