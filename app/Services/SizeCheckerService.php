<?php

namespace App\Services;


class SizeCheckerService
{
    public static function getFields()
    {
        return [
            'total_length',
            'kitake_length',
            'neck_circumference',
            'shoulder_width',
            'yuki_length',
            'sleeve_length',
            'chest_circumference',
            'armpit_to_armpit_width',
            'waist',
            'inseam',
            'hip',
        ];
    }
    public static function getPriorityMap()
    {
        return [
            'total_length' => 'low',
            'kitake_length' => 'low',
            'neck_circumference' => 'high',
            'shoulder_width' => 'high',
            'yuki_length' => 'high',
            'sleeve_length' => 'high',
            'chest_circumference' => 'middle',
            'armpit_to_armpit_width' => 'middle',
            'waist' => 'high',
            'inseam' => 'middle',
            'hip' => 'low',
        ];
    }

    public static function getGuide()
    {
        return [
            'total_length' => '衣類の全長高さ表します。体格や好みにより差があるため、参考程度にご覧ください。',
            'kitake_length' => '上着の裾がウエストからヒップにかかる程度の長さ（身長×0.42）を目安に算出しています。体格や好みにより差があるため、参考程度にご覧ください。',
            'neck_circumference' => '首回り（体格寸法）に+2cmした値を適正サイズとして判定しています。締め付け感に注意してください。',
            'shoulder_width' => '実測値に+2cmした値を目安に判定しています。窮屈にならないようにしましょう。',
            'yuki_length' => '長袖の着用を前提として判定しています。半袖の場合は参考程度にご確認ください。',
            'sleeve_length' => '長袖を基準としています。半袖の場合は適宜調整が必要です。',
            'chest_circumference' => '胸囲は実測値より+6〜8cm程度大きめに作られていることが多いため、目安としてご覧ください。',
            'armpit_to_armpit_width' => '身幅は「胸囲 ÷ 2」を適正値として判定しています。',
            'waist' => '実測値+3cmを適正値としています。締め付けにご注意ください。',
            'inseam' => '長ズボンの前提で判定しています。半ズボンやクロップド丈では適宜調整してください。',
            'hip' => '実測値+3cmを適正値としています。窮屈でないよう注意しましょう。',
        ];
    }

    public static function getSuitableSize($bodyMeasurement, $bodyCorrection)
    {
        $fields = self::getFields();
        $suitableSize = [];

        foreach ($fields as $field) {
            $suitableSize[$field] = $bodyMeasurement->$field + $bodyCorrection->$field;
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
