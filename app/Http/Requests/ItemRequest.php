<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // 必要に応じてユーザーの認可チェック。基本的には true にしておけばOK。
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    // Serviceに移行
    // public function rules(): array
    // {
    //     return [
    //         //画像であるか、拡張子が指定の物か、画像サイズが最大4MBまで
    //         'file_name' => 'required|image|mimes:jpg,jpeg,png|mimetypes:image/jpeg,image/png|max:4096',
    //         'category_id' => 'integer|required|exists:categories,id',
    //         'sub_category_id' => 'integer|required|exists:sub_categories,id',
    //         'brand_id' => 'integer|required|exists:brands,id',
    //         'colors' => 'required|array',
    //         'colors.*' => 'integer|exists:colors,id',
    //         'status' => [Rule::in(['owned', 'cleaning', 'discarded'])],
    //         'is_public' => 'integer|required',
    //         'is_item_suggest' => 'integer|required|between:0,1',
    //         'tags' => 'nullable|array',
    //         'tags.*' => 'integer|exists:tags,id',
    //         'seasons' => 'nullable|array',
    //         'seasons.*' => 'integer|exists:seasons,id',
    //         'main_material' => 'nullable|integer|exists:materials,id',
    //         'sub_material' => 'nullable|integer|exists:materials,id',
    //         'washability_option' => [Rule::in(['washable_machine', 'washable_hand', 'not_washable']), 'nullable'],
    //         'purchased_at' => 'nullable|string|max:20',
    //         'price' => 'integer|nullable',
    //         'memo' => 'string|nullable|max:50',
    //         'neck_circumference' => 'nullable|numeric|between:0,999.0',
    //         'shoulder_width' => 'nullable|numeric|between:0,999.0',
    //         'yuki_length' => 'nullable|numeric|between:0,999.0',
    //         'chest_circumference' => 'nullable|numeric|between:0,999.0',
    //         'waist' => 'nullable|numeric|between:0,999.0',
    //         'inseam' => 'nullable|numeric|between:0,999.0',
    //         'hip' => 'nullable|numeric|between:0,999.0',
    //     ];
    // }
}
