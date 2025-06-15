<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class UserService
{

    //ログイン済みユーザープロフィール編集用
    public static function getEmailUpdateRule(?int $userId = null): array
    {
        return ['required', 'string', 'lowercase', 'email', 'max:50', 'unique:users,email,' . $userId]; //$userIdを語尾に付けると、このユーザーIDのemailのみvalidationの対象から除外される→そのユーザーの既存メールをそのまま使用できる
    }

    // パスワードリセット用：存在するemailが対象
    public static function getExistingEmailRule(): array
    {
        //exists:users,email そのメールのユーザーが存在するか？をチェック
        return ['required', 'string', 'lowercase', 'email', 'max:50', 'exists:users,email'];
    }

    //ユーザー新規登録用
    public static function getUniqueEmailRule(): array
    {
        //exists:users,email そのメールのユーザーが存在するか？をチェック
        return ['required', 'string', 'lowercase', 'email', 'max:50', 'unique:users,email'];
    }

    public static function getPasswordRule(): array
    {
        return ['required', 'confirmed', Rules\Password::defaults()];
    }

    public static function getValidationRules(bool $isRegister = false, ?int $userId = null): array
    {
        $rules = [
            'nickname' => 'required|string|max:20',
            'gender' =>  ['required', Rule::in(['male', 'female', 'prefer_not_to_say'])],
            'prefecture_id' => 'required|integer',
            'city_id' => 'required|integer',
        ];

        if ($isRegister) { //新規ユーザー登録の場合
            $rules['email'] = self::getUniqueEmailRule();
            $rules['password'] = self::getPasswordRule();
        } else { //ログイン済みユーザー更新の場合
            $rules['email'] = self::getEmailUpdateRule($userId);
        }

        return $rules;
    }

    public static function saveUser(array $data, ?User $user = null): User
    {
        $userData = [
            'nickname' => $data['nickname'],
            'email' => $data['email'], //新規user登録時のみ
            'gender' => $data['gender'],
            'prefecture_id' => $data['prefecture_id'] ?? null,
            'city_id' => $data['city_id'] ?? null,
        ];


        if ($user) { //ユーザープロフィール更新
            $user->update($userData);
        } else { //新規ユーザー登録
            $userData['password'] = Hash::make($data['password']); //新規user登録時、パスワードリセット時のみ
            $user = User::create($userData);
        }

        return $user;
    }
}
