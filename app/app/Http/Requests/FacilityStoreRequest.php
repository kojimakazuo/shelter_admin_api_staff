<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FacilityStoreRequest extends FormRequest
{
    public function rules()
    {
        return [
            'image' => 'base64|base64_ext_in:png,svg+xml|base64_max:5',
            'name'  => 'required|max:255',
        ];
    }

    public function messages()
    {
        return [
            'image.base64' => ':attributeの形式が正しくありません',
            'image.base64_ext_in' => 'サポートされている:attributeの拡張子は:extsです',
            'image.base64_max' => ':attributeの最大サイズは:maxMBです',
            'name.required' => ':attributeは必須です',
            'name.max'  => ':attributeが長すぎます',
        ];
    }

    public function attributes()
    {
        return [
            'image' => '設備アイコン',
            'name' => '設備名称',
        ];
    }
}
