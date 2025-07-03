<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Services\WeatherService;
use App\Models\User;
use App\Models\Material;
use App\Models\SubCategory;
use App\Services\ItemService;
use App\Services\ItemRecommendationService;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class HomeController extends Controller
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
        } catch (ModelNotFoundException $e) { //開発環境以外ではユーザーに詳細エラーは出さない
            Log::warning("ユーザーが見つかりません: " . $e->getMessage());
            abort(404, 'ユーザー情報が見つかりません。');
        } catch (Exception $e) {
            Log::error($e);
            abort(500, '内部エラーが発生しました。');
        }

        $weatherSummary = [];
        $weatherMessage = [];
        $topsItem = $bottomsItem = $outerItem = [];

        //天気情報を取得
        $weatherData = WeatherService::getTodayWeather($city->latitude, $city->longitude);
        // $weatherData = null;
        if ($weatherData) {
            try {
                $weatherSummary = WeatherService::extractTodaysSummary($weatherData);

                //天気予報に応じたメッセージの生成
                $materialMap = Material::pluck('name', 'id')->toArray(); //pluck()のみだとcollection型
                $subCategoryMap = SubCategory::pluck('name', 'id')->toArray();

                //天気メッセージ、オススメ衣類テスト用
                // $weatherSummary['temp_min'] =30;
                // $weatherSummary['temp_max'] =35;
                $weatherMessage = WeatherService::generateMessage(
                    $weatherSummary,
                    $materialMap,
                    $subCategoryMap,
                    $user->gender
                );

                //オススメ衣類アイテム
                $recommendedSubCategories = ItemRecommendationService::recommendByTemperature($weatherSummary['temp_max'], $user->gender);

                $topsItem = ItemService::getRecommendedItems($recommendedSubCategories['tops'], $userId);
                $bottomsItem = ItemService::getRecommendedItems($recommendedSubCategories['bottoms'], $userId);
                $outerItem = ItemService::getRecommendedItems($recommendedSubCategories['outers'], $userId);

                // dd($topsItem, $bottomsItem, $outerItem);
            } catch (\Exception $e) {
                Log::error('天気情報の処理中にエラーが発生しました: ' . $e->getMessage());
                // weatherSummaryやrecommend系は空のままでよい
            }
        } else {
            Log::warning("message");('天気APIからのデータが取得できませんでした');
        }

        // dd($weatherSummary, $weatherMessage);

        return view('home', compact('weatherSummary', 'user', 'weatherMessage', 'topsItem', 'bottomsItem', 'outerItem'));
    }
}
