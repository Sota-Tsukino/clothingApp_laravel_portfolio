<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use InterventionImage;
use App\Models\Image;
use Throwable;

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
        $extension = $file->getClientOriginalExtension();
        $fileNameToStore = $fileName . '.' . $extension;

        try {
            //make()で読み込み
            $resizedImage = InterventionImage::make($file)->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->encode(); //encode('jpg')で形式を指定できる
        } catch (Throwable $e) { //通常はExceptionで十分だが、Fatal Error(メモリ不足など)も捕まえるならThrowableを使う
            Log::error('画像処理エラー: ' . $e->getMessage());
            throw new Exception('画像の読み込みに失敗しました。対応形式の画像か確認してください。');
        }

        // laravelのstorage:linkを前提に、下記のpathでstorage/app/public/に保存する
        Storage::put('public/' . $folderName . '/' . $fileNameToStore, $resizedImage);
        return $fileNameToStore;
    }

    public static function deleteAllUserImages($userId)
    {
        $images = Image::where('user_id', $userId)->get();

        foreach ($images as $image) {
            // ファイル削除（DB削除はリレーションで対応する前提）
            $filePath = 'public/items/' . $image->file_name;
            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
            }
        }
    }
}
