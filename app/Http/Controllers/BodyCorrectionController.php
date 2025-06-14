<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BodyCorrection;
use App\Models\BodyMeasurement;
use App\Services\BodyCorrectionService;

class BodyCorrectionController extends Controller
{
    public function edit(Request $request, string $id)
    {
        $fields = array_keys(BodyCorrectionService::$fieldsDefaultValues);//keyのみ取り出して配列に格納
        unset($fields[0]);//「総丈」を除外

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
            'fields' => $fields,
            'bodyCorrection' => $bodyCorrection,
            'bodyMeasurement' => $bodyMeasurement,
            'defaultValues' => BodyCorrectionService::$fieldsDefaultValues,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate(BodyCorrectionService::getValidationRules());

        if ($request->has('from_measurement_id')) {
            session(['from_measurement_id' => $request->input('from_measurement_id')]);
        }

        $bodyCorrection = BodyCorrection::findOrFail($id);

        $fieldKeys = array_keys(BodyCorrectionService::$fieldsDefaultValues);
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
