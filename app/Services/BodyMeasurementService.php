<?php

namespace App\Services;

use App\Models\BodyMeasurement;

class BodyMeasurementService
{
    public static function getFields(): array
    {
        return [
            'height',
            'kitake_length',
            // 'head_circumference',
            'neck_circumference',
            'shoulder_width',
            'yuki_length',
            'sleeve_length',
            'chest_circumference',
            'armpit_to_armpit_width',
            'waist',
            'hip',
            'inseam',
            // 'foot_length',
            // 'foot_circumference',
        ];
    }

    public static function getGuide()
    {
        return [
            'height' => '頭から足裏までの長さを測ります。',
            'head_circumference' => '額の突起部、耳たぶの上、後頭部の突起部を通り、周囲を測定します。',
            'kitake_length' => '上着の裾がウエストからヒップにかかる程度の長さ（身長×0.42）を目安に算出しています。体格や好みにより差があるため、参考程度にご覧ください。',
            'neck_circumference' => '喉の下あたりで首の周囲を1周測定します。',
            'shoulder_width' => '肩先から肩先まで、首の後ろの突起（頸椎点）を通るように測ります。',
            'yuki_length' => '首の後ろの突起から肩を通り、腕を下げた状態で手首までを測ります。',
            'sleeve_length' => '肩の突起から手首まで、腕を下ろした自然な状態で測ります。',
            'chest_circumference' => 'わきの真下にメジャーを当て、胸の最も広い部分を水平に1周測ります。',
            'armpit_to_armpit_width' => '身幅 = 胸囲÷2で算出されます。',
            'waist' => '腰回りで最も細い部分を水平に1周測ります。',
            'inseam' => '脚の内側、股下から足首までの長さを測ります。',
            'hip' => 'お尻の最も太い部分を水平に1周測ります。',
            'foot_length' => 'かかとからつま先までの長さを測ります。',
            'foot_circumference' => '親指と小指の付け根（突起部）を通る1周の長さを測ります。',
        ];
    }

    public static function getValidationRules(bool $withDate = false): array
    {
        $rules = [];
        if ($withDate) {
            $rules['measured_at'] = 'date|required|before_or_equal:today';
        }
        foreach (self::getFields() as $field) {
            $rules[$field] = 'nullable|numeric|between:0,999.0';
        }
        return $rules;
    }

    public static function getLatestForUser($userId)
    {
        return BodyMeasurement::where('user_id', $userId)
            ->orderBy('measured_at', 'desc')
            ->firstOrFail();
    }

    public static function hasBodyMeasurement($userId)
    {
        return BodyMeasurement::where('user_id', $userId)->exists();
    }
}
