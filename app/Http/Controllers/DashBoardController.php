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
        $lat = $user->city->latitude;
        $lon = $user->city->longitude;

        //天気情報を取得
        $weatherData = WeatherService::getTodayWeather($lat, $lon);
        $weatherSummary = WeatherService::extractTodaysSummary($weatherData);
        // dd($weatherSummary);

        return view('dashboard', compact('weatherSummary', 'user'));
    }
}
