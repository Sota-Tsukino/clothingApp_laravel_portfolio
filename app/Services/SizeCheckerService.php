<?php

namespace App\Services;


class SizeCheckerService
{
    public static function getFields()
    {
        return [
            'total_length',
            'kitake_length',
            // 'head_circumference',
            'neck_circumference',
            'shoulder_width',
            'yuki_length',
            'sleeve_length',
            'chest_circumference',
            'armpit_to_armpit_width',
            'waist',
            'inseam',
            'hip',
            // 'foot_length',
            // 'foot_circumference',
        ];
    }
    public static function getPriorityMap()
    {
        return [
            'total_length' => 'low',
            'kitake_length' => 'low',
            'neck_circumference' => 'high',
            'shoulder_width' => 'high',
            'yuki_length' => 'middle',
            'sleeve_length' => 'middle',
            'chest_circumference' => 'middle',
            'armpit_to_armpit_width' => 'middle',
            'waist' => 'high',
            'inseam' => 'middle',
            'hip' => 'middle',
        ];
    }

    public static function getGuide()
    {
        return [
            'total_length' => '衣類の全長高さ表します。体格や好みにより差があるため、参考程度にご覧ください。',
            'kitake_length' => '服の後ろ側で、首の付け根から裾までの長さを測ります。体格や好みにより差があるため、参考程度にご覧ください。',
            'neck_circumference' => 'デフォルトでは、体格寸法に+2cmした値を適正サイズとして判定しています。締め付け感に注意してください。',
            'shoulder_width' => 'デフォルトでは、体格寸法に+2cmした値を目安に判定しています。窮屈にならないようにしましょう。',
            'yuki_length' => '長袖の着用を前提として判定しています。半袖の場合は参考程度にご確認ください。',
            'sleeve_length' => '長袖の着用を前提として判定しています。半袖の場合は参考程度にご確認ください。',
            'chest_circumference' => '+6〜8cm程度大きめに作られていることが多いため、目安としてご覧ください。',
            'armpit_to_armpit_width' => 'トップスの両わき下の縫い目の間を測ります。デフォルトでは、身幅は「胸囲 ÷ 2」を適正値として判定しています。',
            'waist' => 'デフォルトでは、体格寸法+3cmを適正値としています。締め付けにご注意ください。',
            'inseam' => '長ズボンの前提で判定しています。半ズボンやクロップド丈では適宜調整してください。',
            'hip' => 'デフォルトでは、体格寸法+3cmを適正値としています。窮屈でないよう注意しましょう。',
        ];
    }

    public static function getSuitableSize($bodyMeasurement, $bodyCorrection)
    {
        $fields = self::getFields();
        $suitableSize = [];

        foreach ($fields as $field) {
            if (is_null($bodyMeasurement->$field)) {
                $suitableSize[$field] =  null;
            } else {
                $suitableSize[$field] =  $bodyMeasurement->$field + $bodyCorrection->$field;
            }
        }

        return $suitableSize;
    }

    public static function getItemSize($item)
    {
        $fields = self::getFields();
        $itemSize = [];

        foreach ($fields as $field) {
            $itemSize[$field] = $item->$field;
        }

        return $itemSize;
    }
}
