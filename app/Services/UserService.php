<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class UserService
{
    public static function getValidationRules(bool $isRegister = false, ?int $userId = null): array
    {
        $rules = [
            'nickname' => 'required|string|max:20',
            'email' => 'required|string|lowercase|email|max:50|unique:users,email,' . $userId, //unique:テーブル名、カラム名、除外するID
            'gender' =>  ['required', Rule::in(['male', 'female', 'prefer_not_to_say'])],
            'prefecture_id' => 'required|integer',
            'city_id' => 'required|integer',
        ];

        if ($isRegister) {
            $rules['password'] = ['required', 'confirmed', Rules\Password::defaults()];
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
