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
        try {
            //make()で読み込み
            $resizedImage = InterventionImage::make($imageFile)->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->encode(); //encode('jpg')で形式を指定できる

            // ランダムファイル名
            $fileName = uniqid() . '.jpg';
            $path = $folderName . '/' . $fileName;

            // S3 にアップロード（privateで）
            Storage::disk('s3')->put($path, (string) $resizedImage, 'private');

            return $fileName;
        } catch (Throwable $e) { //通常はExceptionで十分だが、Fatal Error(メモリ不足など)も捕まえるならThrowableを使う
            Log::error('画像処理エラー: ' . $e->getMessage());
            throw new Exception('画像の読み込みに失敗しました。対応形式の画像か確認してください。');
        }
    }

    public static function deleteAllUserImages($userId)
    {
        $images = Image::where('user_id', $userId)->get();

        foreach ($images as $image) {
            // ファイル削除（DB削除はリレーションで対応する前提）
            $filePath = 'items/' . $image->file_name;
            if (Storage::disk('s3')->exists($filePath)) {
                Storage::disk('s3')->delete($filePath);
            }
        }
    }
}
