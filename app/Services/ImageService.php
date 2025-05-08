<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Storage;
use InterventionImage;

class ImageService
{
    public static function upload($imageFile, $folderName)
    {
        // dd($imageFile);
        if (is_array($imageFile)) {
            $file = $imageFile['image']; // 配列なので[ʻkeyʼ] で取得
        } else {
            $file = $imageFile;
        }
        $fileName = uniqid(rand() . '_'); //ランダム関数で重複しないファイル名を作る
        $extension = $file->getClientOriginalExtension(); // extension()では取れなかった？
        $fileNameToStore = $fileName . '.' . $extension;
        // dd($file, $fileName, $extension, $fileNameToStore);

        try {
            //make()で読み込み
            $resizedImage = InterventionImage::make($file)->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->encode();//encode('jpg')で形式を指定できる
        } catch (Exception $e) { //Exception, throwable 適切なのは？違いは何か？
            Log::error('画像処理エラー: ' . $e->getMessage());
            throw new Exception('画像の読み込みに失敗しました。対応形式の画像か確認してください。');
        }

        // laravelのstorage:linkを前提に、下記のpathでstorage/app/public/に保存する
        Storage::put('public/' . $folderName . '/' . $fileNameToStore, $resizedImage);
        return $fileNameToStore;
    }
}
