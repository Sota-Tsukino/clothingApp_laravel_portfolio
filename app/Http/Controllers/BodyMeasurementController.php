<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\BodyMeasurement;
use App\Models\BodyCorrection;
use App\Services\BodyMeasurementService;

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
        // dd($request);

        try {
            // $bodyMeasurement = BodyMeasurement::create([
            //     'user_id' => Auth::id(),
            //     'measured_at' => $request->measured_at,
            //     'height' => $request->height,
            //     'head_circumference' => $request->head_circumference,
            //     'neck_circumference' => $request->neck_circumference,
            //     'shoulder_width' => $request->shoulder_width,
            //     'yuki_length' => $request->yuki_length,
            //     'sleeve_length' => $request->sleeve_length,
            //     'chest_circumference' => $request->chest_circumference,
            //     'waist' => $request->waist,
            //     'hip' => $request->hip,
            //     'inseam' => $request->inseam,
            //     'foot_length' => $request->foot_length,
            //     'foot_circumference' => $request->foot_circumference,
            // ]);


            // ↓の動作確認
            // $datas = $request->only('measured_at', 'height', 'waist');// ['key' => value]で返す
            // $datas = array_merge(['measured_at'], BodyMeasurementService::getFields());
            // $datas = $request->only(array_merge(['measured_at'], BodyMeasurementService::getFields()));
            // dd($datas);

            //リファクタリング
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

        //model型で取得 first()でもokでも
        $bodyCorrection = BodyCorrection::where('user_id', Auth::id())->firstOrFail();

        $suitableSize = [];
        foreach (BodyMeasurementService::getFields() as $field) {
            // if (!empty($bodyMeasurement->$field)) {
            //     $suitableSize[$field] = $bodyMeasurement->$field + $bodyCorrection->$field;
            //     continue;
            // }
            // $suitableSize[$field] = '未登録';
            $suitableSize[$field] = !empty($bodyMeasurement->$field) ? $bodyMeasurement->$field + $bodyCorrection->$field : '未登録';
        }

        // return view('bodymeasurement.show', compact('bodyMeasurement', 'bodyCorrection', 'suitableSize', 'fields'));
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
        $bodyMeasurement->fill($request->only(BodyMeasurementService::getFields()))->save(); //リファクタリング

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
