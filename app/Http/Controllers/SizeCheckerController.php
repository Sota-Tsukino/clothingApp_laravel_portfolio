<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\BodyMeasurementService;
use App\Services\BodyCorrectionService;
use App\Services\FittingToleranceService;
use App\Services\SizeCheckerService;

class SizeCheckerController extends Controller
{
    public function index(Request $request)
    {

        $userId = Auth::id();
        if (!BodyMeasurementService::hasBodyMeasurement($userId)) {
            return redirect()
                ->route(Auth::user()->role === 'admin' ? 'admin.measurement.create' : 'measurement.create')
                ->with([
                    'message' => 'サイズチェッカー機能を利用するには、体格情報を登録してください。',
                    'status' => 'alert'
                ]);
        }
        //セッションに体格情報IDを保持させ、サイズチェッカー画面で戻るボタン押した際にこれをparamで渡す。
        if ($request->has('from_measurement_id')) {
            session(['from_measurement_id' => $request->input('from_measurement_id')]);
        }
        
        $bodyMeasurement = BodyMeasurementService::getLatestForUser($userId);
        $bodyCorrection = BodyCorrectionService::getForUser($userId);
        $suitableSize = SizeCheckerService::getSuitableSize($bodyMeasurement, $bodyCorrection);
        $userTolerance = FittingToleranceService::getForUser($userId);
        $fields = SizeCheckerService::getFields();
        unset($fields[0]); //「総丈」を除外
        $guides = SizeCheckerService::getGuide();
        $priorityMap = SizeCheckerService::getPriorityMap();

        return view('sizechecker.index', compact('bodyMeasurement', 'suitableSize', 'fields', 'userTolerance', 'guides', 'priorityMap'));
    }
}
