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

        //セッションに体格情報IDを保持させ、サイズチェッカー画面で戻るボタン押した際にこれをparamで渡す。
        if ($request->has('from_measurement_id')) {
            session(['from_measurement_id' => $request->input('from_measurement_id')]);
        }

        $userId = Auth::id();
        $bodyMeasurement = BodyMeasurementService::getLatestForUser($userId);
        $bodyCorrection = BodyCorrectionService::getForUser($userId);
        $suitableSize = SizeCheckerService::getSuitableSize($bodyMeasurement, $bodyCorrection);
        $userTolerance = FittingToleranceService::getForUser($userId);
        $fields = SizeCheckerService::getFields();
        $guides = SizeCheckerService::getGuide();

        return view('sizechecker.index', compact('bodyMeasurement', 'suitableSize', 'fields', 'userTolerance', 'guides'));
    }
}
