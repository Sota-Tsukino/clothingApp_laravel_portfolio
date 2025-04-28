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
            $rules[$field] = 'numeric|between:0,9';
        }
        return $rules;
    }

    public function edit(Request $request, string $id)
    {
        //セッションに体格情報IDを保持させ、補正値画面で戻るボタン押した際にこれをparamで渡す。
        if ($request->has('from_measurement_id')) {
            session(['from_measurement_id' => $request->input('from_measurement_id')]);
        }

        $bodyCorrection = BodyCorrection::Findorfail($id);
        //参照する体格情報が、ログインユーザー所有のものか？を判定
        if ($bodyCorrection->user_id !== Auth::id()) {
            return redirect()
                ->route(Auth::user()->role === 'admin' ? 'admin.measurement.index' : 'measurement.index')
                ->with([
                    'message' => '他のユーザーの体格補正値は参照できません。',
                    'status' => 'alert'
                ]);
        }
        $bodyMeasurement = bodyMeasurement::Findorfail($request->from_measurement_id);
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
            // 'bodyMeasurement' => $bodyMeasurement,
            'fields' => $this->fields,
            'bodyCorrection' => $bodyCorrection,
            'bodyMeasurement' => $bodyMeasurement,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate($this->validationRules());

        if ($request->has('from_measurement_id')) {
            session(['from_measurement_id' => $request->input('from_measurement_id')]);
        }

        $bodyCorrection = BodyCorrection::Findorfail($id);

        $bodyCorrection->fill($request->only($this->fields))->save(); //リファクタリング
        $bodyCorrection->save();

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
