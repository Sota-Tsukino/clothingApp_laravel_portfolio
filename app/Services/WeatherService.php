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
        // dd($afternoon);

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

    public static function generateMessage(array $weatherSummary, array $materialMap, array $subCategoryMap)
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
            'red' => [],
            'yellow' => [],
            'green' => [],
            'teal' => [],
            'cyan' => [],
            'sky' => [],
            'blue' => [],
        ];

        //メッセージ表示テスト用
        $tempMax = 24;
        $tempMin = 20;

        //日中気温の推奨衣類
        if ($tempMax !== null) {
            foreach (config('clothing_recommendations.temperature_ranges') as $range) {
                if (
                    ($range['min'] === null || $tempMax >= $range['min']) &&
                    ($range['max'] === null || $tempMax < $range['max'])
                ) {
                    $msgs[$range['color']][] = "日中は{$range['feel']}感じられそうです。";

                    // material_id → name
                    $materialNames = collect($range['materials'])
                        ->map(fn($id) => isset($materialMap[$id]) ? __('material.' . $materialMap[$id]) : null)
                        ->filter()//$materialMap[$id]が存在しない場合にnullが返るので取り除く
                        ->implode('、');


                    // tops の sub_category_id → name
                    $topsNames = collect($range['tops'])
                        ->map(fn($id) => isset($subCategoryMap[$id]) ? __('subcategory.' . $subCategoryMap[$id]) : null)
                        ->filter()
                        ->implode('、');


                    $msgs[$range['color']][] = "{$materialNames}素材の{$topsNames}などがおすすめです。";
                    break;
                }
            }
        }

        // 寒暖差によるアドバイス
        if ($tempMax !== null && $tempMin !== null) {
            $diff = $tempMax - $tempMin;
            if ($diff >= 7) {
                $msgs['yellow'][] = '寒暖差が激しいので、体温調節できる服装を心がけましょう。';
            }
        }

        // 湿度
        if ($humidity !== null && $humidity >= 70 && $tempMax >= 24) {
            $msgs['yellow'][] = '湿度が高めなので、蒸し暑く感じるかもしれません。';
        }

        // 天気の状態から
        if (Str::contains($descText, '雨')) {
            $msgs['blue'][] = '雨の予報です。傘をお忘れなく。ナイロン素材のウィンドブレーカーもおすすめ。';
        }
        if (Str::contains($descText, '雪')) {
            $msgs['blue'][] = '雪の予報です。滑りやすいので足元にご注意ください。';
        }
        if (Str::contains($descText, '雷')) {
            $msgs['yellow'][] = '雷の可能性があります。外出の際はご注意ください。';
        }

        // 情報が不足している場合
        if (!$tempMax || !$tempMin) {
            $msgs['yellow'][] = '天気情報が一部取得できませんでした。';
        }

        return $msgs;
    }
}
