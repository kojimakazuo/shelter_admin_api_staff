<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShelterStoreImageRequest extends FormRequest
{
    public function rules()
    {
        return [
            'image' => 'base64|base64_ext_in:jpeg,jpg,png|base64_max:5',
        ];
    }

    public function messages()
    {
        return [
            'image.base64' => ':attributeの形式が正しくありません',
            'image.base64_ext_in' => 'サポートされている:attributeの拡張子は:extsです',
            'image.base64_max' => ':attributeの最大サイズは:maxMBです',
        ];
    }

    public function attributes()
    {
        return [
            'image' => '避難所画像',
        ];
    }
}
