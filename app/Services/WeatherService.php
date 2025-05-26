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

        // 気温帯に応じた体感と衣類のマッピング
        $tempBands = [
            ['min' => 29.5, 'feel' => '暑く', 'material' => '通気性・吸湿性の良い麻（リネン）、綿（コットン）', 'clothes' => '半袖シャツ、ポロシャツ', 'type' => 'danger'],
            ['min' => 24.5, 'feel' => 'やや暑く', 'material' => '麻（リネン）、綿（コットン）',  'clothes' => '半袖シャツ、ポロシャツ', 'type' => 'warning'],
            ['min' => 20.5, 'feel' => '温かく', 'material' => '綿（コットン）ポリエステル', 'clothes' => '長袖シャツ、ロングTシャツ', 'type' => 'info'],
            ['min' => 16.5, 'feel' => '涼しく', 'material' => '綿（コットン）ポリエステル', 'clothes' => 'カーディガン、ストールなどの薄手の織物', 'type' => 'info'],
            ['min' => 12.5, 'feel' => 'やや肌寒く', 'material' => '軽いアクリル、ウール', 'clothes' => 'セーター、トレーナー、パーカー', 'type' => 'info'],
            ['min' => 8.5,  'feel' => '肌寒く', 'material' => 'アクリル、ウール', 'clothes' => 'フリース、ボア', 'type' => 'info'],
            ['min' => 5.5,  'feel' => '冬の寒さを', 'material' => '厚手のアクリル、ウール', 'clothes' => '冬物コート', 'type' => 'info'],
            ['min' => -99, 'feel' => '本格的な冬の寒さを', 'material' => '厚手のアクリル、ウール、キャメル', 'clothes' => 'ダウン、ボア、マフラー、手袋などの防寒', 'type' => 'info'],
        ];

        $tempMax= 26;
        $tempMin= 23;

        //日中気温の推奨衣類
        if ($tempMax !== null && $tempMin !== null) {
            foreach ($tempBands as $band) {
                if ($tempMax >= $band['min']) {
                    $msgs[$band['type']][] = "日中は{$band['feel']}感じられそうです。";
                    $msgs[$band['type']][] = "{$band['material']}素材の{$band['clothes']}がおすすめです。";
                    break;
                }
            }
        }

        // 寒暖差によるアドバイス
        if ($tempMax !== null && $tempMin !== null) {
            $diff = $tempMax - $tempMin;
            if ($diff >= 7) {
                $msgs['warning'][] = '寒暖差が激しいので、体温調節できる服装を心がけましょう。';
            }
        }

        // 湿度
        if ($humidity !== null && $humidity >= 70 && $tempMax >= 24) {
            $msgs['warning'][] = '湿度が高めなので、蒸し暑く感じるかもしれません。';
        }

        // 天気の状態から
        if (Str::contains($descText, '雨')) {
            $msgs['info'][] = '雨の予報です。傘をお忘れなく。ナイロン素材のウィンドブレーカーもおすすめ。';
        }
        if (Str::contains($descText, '雪')) {
            $msgs['info'][] = '雪の予報です。滑りやすいので足元にご注意ください。';
        }
        if (Str::contains($descText, '雷')) {
            $msgs['warning'][] = '雷の可能性があります。外出の際はご注意ください。';
        }

        // 情報が不足している場合
        if (!$tempMax || !$tempMin) {
            $msgs['warning'][] = '天気情報が一部取得できませんでした。';
        }


        //どれにも当てはまらない場合
        if (empty($msgs['info']) && empty($msgs['warning']) && empty($msgs['danger'])) {
            $msgs['info'][] = '穏やかな天気が予想されています。気持ちの良い一日になりそうです。';
        }

        return $msgs;
    }
}
