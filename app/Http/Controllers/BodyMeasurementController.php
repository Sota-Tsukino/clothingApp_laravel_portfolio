<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\BodyMeasurement;
use App\Models\BodyCorrection;
use Carbon\Carbon;

class BodyMeasurementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::findOrFail(Auth::id());
        $bodyMeasurements = $user->bodymeasurements;
        // dd($bodyMeasurements);
        return view('bodymeasurement.index', compact('bodyMeasurements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $fields = [
            'height',
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
        return view('bodymeasurement.create', compact('fields'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'measured_at' => 'date|required|before_or_equal:today', //今日の日付けよりも前の日か？
            'height' => 'nullable|numeric|between:0,999.0',
            'head_circumference' => 'nullable|numeric|between:0,999.0',
            'neck_circumference' => 'nullable|numeric|between:0,999.0',
            'shoulder_width' => 'nullable|numeric|between:0,999.0',
            'yuki_length' => 'nullable|numeric|between:0,999.0',
            'sleeve_length' => 'nullable|numeric|between:0,999.0',
            'chest_circumference' => 'nullable|numeric|between:0,999.0',
            'waist' => 'nullable|numeric|between:0,999.0',
            'hip' => 'nullable|numeric|between:0,999.0',
            'inseam' => 'nullable|numeric|between:0,999.0',
            'foot_length' => 'nullable|numeric|between:0,999.0',
            'foot_circumference' => 'nullable|numeric|between:0,999.0',
        ]);
        // dd($request);

        try {
            $bodyMeasurement = BodyMeasurement::create([
                'user_id' => Auth::id(),
                'measured_at' => $request->measured_at,
                'height' => $request->height,
                'head_circumference' => $request->head_circumference,
                'neck_circumference' => $request->neck_circumference,
                'shoulder_width' => $request->shoulder_width,
                'yuki_length' => $request->yuki_length,
                'sleeve_length' => $request->sleeve_length,
                'chest_circumference' => $request->chest_circumference,
                'waist' => $request->waist,
                'hip' => $request->hip,
                'inseam' => $request->inseam,
                'foot_length' => $request->foot_length,
                'foot_circumference' => $request->foot_circumference,
            ]);

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
        // dd($bodyMeasurement);

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
        $bodyCorrection = BodyCorrection::where('user_id',Auth::id())->firstOrFail();

        $fields = [
            'height',
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

        $suitableSize = [];
        foreach ($fields as $field) {
            if (!empty($bodyMeasurement->$field)) {
                $suitableSize[$field] = $bodyMeasurement->$field + $bodyCorrection->$field;
                continue;
            }
            $suitableSize[$field] = '未登録';
        }

        return view('bodymeasurement.show', compact('bodyMeasurement', 'bodyCorrection', 'suitableSize', 'fields'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $bodyMeasurement = BodyMeasurement::findOrFail($id);

        //参照する体格情報が、ログインユーザー所有のものか？を判定
        if ($bodyMeasurement->user_id !== Auth::id()) {
            return redirect()
                ->route(Auth::user()->role === 'admin' ? 'admin.measurement.index' : 'measurement.index')
                ->with([
                    'message' => '他のユーザーの体格情報は編集できません。',
                    'status' => 'alert'
                ]);
        }

        $fields = [
            'height',
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

        return view('bodymeasurement.edit', compact('bodyMeasurement', 'fields'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'height' => 'nullable|numeric|between:0,999.0', //※min|maxだと整数比較になる
            'head_circumference' => 'nullable|numeric|between:0,999.0', //numeric　数値かどうか
            'neck_circumference' => 'nullable|numeric|between:0,999.0',
            'shoulder_width' => 'nullable|numeric|between:0,999.0',
            'yuki_length' => 'nullable|numeric|between:0,999.0',
            'sleeve_length' => 'nullable|numeric|between:0,999.0',
            'chest_circumference' => 'nullable|numeric|between:0,999.0',
            'waist' => 'nullable|numeric|between:0,999.0',
            'hip' => 'nullable|numeric|between:0,999.0',
            'inseam' => 'nullable|numeric|between:0,999.0',
            'foot_length' => 'nullable|numeric|between:0,999.0',
            'foot_circumference' => 'nullable|numeric|between:0,999.0',
        ]);


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

        $fields = [
            'height',
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

        foreach ($fields as $field) {
            $bodyMeasurement->$field = $request->$field;
        }

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

        // dd('destroy');
        $bodyMeasurement->delete();
        return redirect()
            ->route(Auth::user()->role === 'admin' ? 'admin.measurement.index' : 'measurement.index')
            ->with([
                'message' => '体格情報を削除しました。',
                'status' => 'info'
            ]);
    }
}
