<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\WeatherService;
use App\Models\User;
use Exception;

class DashBoardController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        try {
            //ユーザーの位置情報を取得
            $user = User::with(['prefecture', 'city'])->findOrFail(Auth::id());
            $city = $user->city;
            $city->ensureCoordinates();
        } catch (Exception $e) {
            abort(400, $e->getMessage());
        }


        //天気情報を取得
        $weatherData = WeatherService::getTodayWeather($city->latitude, $city->longitude);
        $weatherSummary = WeatherService::extractTodaysSummary($weatherData);
        $weatherMessage = WeatherService::generateMessage($weatherSummary);

        // dd($weatherMessage);

        return view('dashboard', compact('weatherSummary', 'user', 'weatherMessage'));
    }
}
