<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\BodyMeasurement;
use App\Models\BodyCorrection;
use App\Services\BodyMeasurementService;
use App\Services\BodyCorrectionService;
use App\Services\SizeCheckerService;

class BodyMeasurementController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();
        $bodyMeasurements = BodyMeasurement::where('user_id', $userId)
            ->orderBy('measured_at', 'desc')->get();

        return view('bodymeasurement.index', compact('bodyMeasurements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        //$fields変数にこのクラスのprivate変数を代入
        return view('bodymeasurement.create', [
            'fields' => BodyMeasurementService::getFields(),
            'guides' => BodyMeasurementService::getGuide(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(BodyMeasurementService::getValidationRules(true));

        try {
            $bodyMeasurement = BodyMeasurement::create(array_merge(
                $request->only(array_merge(['measured_at'], BodyMeasurementService::getFields())), //
                ['user_id' => Auth::id()]
            ));

            // ここで体格補正も自動作成
            if (!BodyCorrection::where('user_id', Auth::id())->exists()) {
                BodyCorrection::create([
                    'user_id' => Auth::id(),
                    // 各補正値カラムはDB側でdefault値が設定されているので、ここで渡さなくてOK
                ]);
            }
        } catch (Throwable $e) {
            Log::error($e);
            throw $e;
        }

        return redirect()
            ->route(Auth::user()->role === 'admin' ? 'admin.measurement.show' : 'measurement.show', ['measurement' => $bodyMeasurement->id])
            ->with([
                'message' => '体格情報を登録しました。',
                'status' => 'info'
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $userId = Auth::id();
        $bodyMeasurement = BodyMeasurement::findOrFail($id);

        //参照する体格情報が、ログインユーザー所有のものか？を判定
        if ($bodyMeasurement->user_id !== Auth::id()) {
            return redirect()
                ->route(Auth::user()->role === 'admin' ? 'admin.measurement.index' : 'measurement.index')
                ->with([
                    'message' => '他のユーザーの体格情報は参照できません。',
                    'status' => 'alert'
                ]);
        }

        $bodyCorrection = BodyCorrectionService::getForUser($userId);
        $suitableSize = SizeCheckerService::getSuitableSize($bodyMeasurement, $bodyCorrection);

        return view('bodymeasurement.show', [
            'bodyMeasurement' => $bodyMeasurement,
            'bodyCorrection' => $bodyCorrection,
            'suitableSize' => $suitableSize,
            'fields' => BodyMeasurementService::getFields(),
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $bodyMeasurement = BodyMeasurement::findOrFail($id);
        $guides = BodyMeasurementService::getGuide();

        //参照する体格情報が、ログインユーザー所有のものか？を判定
        if ($bodyMeasurement->user_id !== Auth::id()) {
            return redirect()
                ->route(Auth::user()->role === 'admin' ? 'admin.measurement.index' : 'measurement.index')
                ->with([
                    'message' => '他のユーザーの体格情報は編集できません。',
                    'status' => 'alert'
                ]);
        }

        // return view('bodymeasurement.edit', compact('bodyMeasurement', 'fields'));
        return view('bodymeasurement.edit', [
            'bodyMeasurement' => $bodyMeasurement,
            'fields' => BodyMeasurementService::getFields(),
            'guides' => $guides,

        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate(BodyMeasurementService::getValidationRules());

        //更新する対象の体格情報idを取得
        $bodyMeasurement = BodyMeasurement::findOrFail($id);

        //体格情報がログインユーザー所有か？
        if ($bodyMeasurement->user_id !== Auth::id()) {
            return redirect()
                ->route(Auth::user()->role === 'admin' ? 'admin.measurement.edit' : 'measurement.edit')
                ->with([
                    'message' => '他のユーザーの体格情報は編集できません。',
                    'status' => 'alert'
                ]);
        }

        // foreach (BodyMeasurementService::getFields() as $field) {
        //     $bodyMeasurement->$field = $request->$field;
        // }
        $bodyMeasurement->fill($request->only(array_merge(['measured_at'], BodyMeasurementService::getFields())))->save(); //リファクタリング

        $bodyMeasurement->save();

        return redirect()
            ->route(Auth::user()->role === 'admin' ? 'admin.measurement.show' : 'measurement.show', ['measurement' => $bodyMeasurement->id])
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
        $bodyMeasurement = BodyMeasurement::findOrFail($id);
        //体格情報がログインユーザー所有か？
        if ($bodyMeasurement->user_id !== Auth::id()) {
            return redirect()
                ->route(Auth::user()->role === 'admin' ? 'admin.measurement.edit' : 'measurement.edit')
                ->with([
                    'message' => '他のユーザーの体格情報は削除できません。',
                    'status' => 'alert'
                ]);
        }

        $bodyMeasurement->delete();
        return redirect()
            ->route(Auth::user()->role === 'admin' ? 'admin.measurement.index' : 'measurement.index')
            ->with([
                'message' => '体格情報を削除しました。',
                'status' => 'info'
            ]);
    }
}
