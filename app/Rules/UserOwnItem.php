<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class UserOwnItem implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // より安全な型チェックを加える（intでないものが来たときの保護）
        if (!is_numeric($value)) {
            $fail('不正なIDが含まれています。');
            return;
        }
        
        $isUserOwn = Item::where('id', $value)
            ->where('user_id', Auth::id())
            ->exists();

        if (!$isUserOwn) {
            $fail('他人の衣類アイテムは登録できません。');
        }
    }
}
