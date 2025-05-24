<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class WeatherService
{
    public static function getTodayWeather(float $lat, float $lon)
    {
        $query_data = [
            'lat' => $lat,
            'lon' => $lon,
            'lang' => 'ja',
            'units' => 'metric', //摂氏（℃）で表示
            'appid' => config('services.openweather.key'),
        ];


        // excludeのparamが','で出力されるのは"%2C"にエンコードされている為
        //出力結果　https://api.openweathermap.org/data/2.5/forecast?lat=33.44&lon=-94.04&exclude=current,minutely,hourly&lang=ja&appid=...
        // dd($url);


        $response = Http::get('https://api.openweathermap.org/data/2.5/forecast', $query_data);

        return json_decode($response->getBody(), true); // true を渡すと連想配列になる
    }

    public static function extractTodaysSummary(array $data): array
    {
        $today = now()->format('Y-m-d');
        //collectionクラスに変換し、filter(),first(),min(),max()等を使えるようにする
        // use()はクロージャ（無名関数）に対して、外の変数を関数内で使用する場合に記載
        $forecasts = collect($data['list'])->filter(function ($item) use ($today) {
            //'2025-05-22 12:00:00' が '2025-05-22' で始まるか？を判定
            return str_starts_with($item['dt_txt'], $today);
        });
        // dd($data, $forecasts);

        $morningHours = ['09:00:00', '12:00:00'];
        $afternoonHours = ['15:00:00', '18:00:00'];

        //substr($item['dt_txt'], 11)で時刻のみ切り出す
        $morning = $forecasts->first(fn($item) => in_array(substr($item['dt_txt'], 11), $morningHours));
        $afternoon = $forecasts->first(fn($item) => in_array(substr($item['dt_txt'], 11), $afternoonHours));

        return [
            'morning_icon' => $morning['weather'][0]['icon'] ?? null,
            'afternoon_icon' => $afternoon['weather'][0]['icon'] ?? null,
            'morning_desc' => $morning['weather'][0]['description'] ?? null,
            'afternoon_desc' => $afternoon['weather'][0]['description'] ?? null,
            'temp_min' => $forecasts->min(fn($item) => $item['main']['temp_min']),
            'temp_max' => $forecasts->max(fn($item) => $item['main']['temp_max']),
            'humidity' => $morning['main']['humidity'] ?? $afternoon['main']['humidity'] ?? null,
        ];
    }

    public static function fetchCoordinatesByCityName(string $cityName): ?array
    {

        $query_data = [
            'format' => 'json',
            'q' => $cityName,
            'accept-language' => 'ja'
        ];

        $url = 'https://nominatim.openstreetmap.org/search';

        //request headerにuser-agentを明示的に指定する
        $response = Http::withHeaders([
            'User-Agent' => 'ClothingApp/1.0 (rizhidashi@gmail.com)'
        ])->get($url, $query_data);

        if ($response->failed()) {
            logger()->error('Nominatim API Error', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            return null;
        }

        $results = $response->json();

        if (!empty($results)) {
            return [
                'latitude' => $results[0]['lat'],
                'longitude' => $results[0]['lon'],
            ];
        }

        return null;
    }

    public static function generateMessage(array $weatherSummary)
    {
        $tempMax = $weatherSummary['temp_max'] ?? null;
        $tempMin = $weatherSummary['temp_min'] ?? null;
        $humidity = $weatherSummary['humidity'] ?? null;
        $descs = array_filter([
            $weatherSummary['morning_desc'] ?? null,
            $weatherSummary['afternoon_desc'] ?? null,
        ]);
        $descText = implode('・', array_unique($descs));

        //msgTypeを判別して、blade側で色の変更
        $msgs = [
            'info' => [], //blue
            'warning' => [], //yellow
            'danger' => [], //red
        ];

        if (!$tempMax || !$tempMin) {
            $msgs['warning'][] = '天気情報が一部取得できませんでした。';
        }

        // 気温差の条件
        if ($tempMax >= 24 && $tempMin <= 15) {
            $msgs['info'][] = '日中は暖かいですが、朝晩は冷えるので羽織りものがあると安心です。';
        }

        if ($tempMax <= 16) {
            $msgs['info'][] = '気温が少し低いので、織物があると安心です。';
        }

        if ($tempMax - $tempMin >= 7) {
            $msgs['warning'][] = '寒暖差が激しいので、体調管理にご注意を。';
        }

        // 湿度
        if ($humidity >= 70 && $tempMax >= 24) {
            $msgs['warning'][] = '湿度が高めなので、蒸し暑く感じるかもしれません。';
        }

        // 天気
        if (Str::contains($descText, '雨')) {
            $msgs['info'][] =  '雨の予報です。傘をお持ちください。';
        }

        if (Str::contains($descText, '雪')) {
            $msgs['info'][] =  '雪の予報です。足元にご注意ください。';
        }

        if (Str::contains($descText, '雷')) {
            $msgs['warning'][] =  '雷の可能性があります。外出にはご注意ください。';
        }

        if ($tempMax >= 30) {
            $msgs['danger'][] =  '非常に暑くなる予報です。水分補給をこまめに。';
        }


        if (empty($msgs['info']) && empty($msgs['warning']) && empty($msgs['danger'])) {
            $msgs['info'][] = '穏やかな天気が予想されています。気持ちの良い一日になりそうです。';
        }

        //  dd($msgs);
        return $msgs;
    }
}
