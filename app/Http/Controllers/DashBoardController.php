<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\WeatherService;
use App\Models\User;

class DashBoardController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //ユーザーの位置情報を取得
        $user = User::with(['prefecture', 'city'])->findOrFail(Auth::id());
        $latitude = $user->city->latitude;
        $longitude = $user->city->longitude;
        // dd($latitude, $longitude);

        $weather = WeatherService::getTodayWeather($latitude, $longitude);


        // $userId = Auth::id();
        dd($weather);

        // return view('fittingtolerance.index', compact('fittingTolerances', 'userId'));
    }
}
