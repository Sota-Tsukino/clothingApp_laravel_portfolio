<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\WeatherService;
use App\Models\User;
use App\Services\ItemService;
use App\Services\ItemRecommendationService;
use Exception;

class DashBoardController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();

        try {
            //ユーザーの位置情報を取得
            $user = User::with(['prefecture', 'city'])->findOrFail($userId);
            $city = $user->city;
            $city->ensureCoordinates();
        } catch (Exception $e) {
            abort(400, $e->getMessage());
        }


        //天気情報を取得
        $weatherData = WeatherService::getTodayWeather($city->latitude, $city->longitude);
        $weatherSummary = WeatherService::extractTodaysSummary($weatherData);
        $weatherMessage = WeatherService::generateMessage($weatherSummary);

        // dd($weatherSummary);
        //オススメ衣類アイテム
        $recommendedCategories = ItemRecommendationService::recommendByTemperature($weatherSummary['temp_max']);

        // dd($recommendedCategories['tops']);
        $topsItems = ItemService::getRecommendedItems($recommendedCategories['tops'], $userId);
        $bottomsItems = ItemService::getRecommendedItems($recommendedCategories['bottoms'], $userId);
        $outerItems = ItemService::getRecommendedItems($recommendedCategories['outer'], $userId);

        // dd($weatherMessage);

        return view('dashboard', compact('weatherSummary', 'user', 'weatherMessage'));
    }
}
