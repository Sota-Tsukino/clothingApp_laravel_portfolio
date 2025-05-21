<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class WeatherService
{
    public static function getTodayWeather(float $lat, float $lon)
    {
        $query_data = [
            'lat' => $lat,
            'lon' => $lon,
            // 'exclude' => 'current,minutely,hourly',
            'lang' => 'ja',
            'units' => 'metric', //摂氏（℃）で表示
            'appid' => config('services.openweather.key'),
        ];

        // $url = 'https://api.openweathermap.org/data/2.5/weather?' . http_build_query($query_data);

        // excludeのparamが','で出力されるのは"%2C"にエンコードされている為
        //出力結果　https://api.openweathermap.org/data/2.5/forecast?lat=33.44&lon=-94.04&exclude=current,minutely,hourly&lang=ja&appid=...
        // dd($url);

        $response = Http::get('https://api.openweathermap.org/data/2.5/forecast', $query_data);

        return json_decode($response->getBody(), true); // true を渡すと連想配列になる
    }
}
