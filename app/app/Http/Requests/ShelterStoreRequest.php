<?php

namespace App\Http\Requests;

use App\Enums\DisasterType;
use App\Enums\ShelterType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ShelterStoreRequest extends FormRequest
{
    public function rules()
    {
        return [
            'images' => 'array',
            'images.*' => 'base64|base64_ext_in:jpeg,jpg,png|base64_max:5',
            'name'  => 'required|max:255',
            'name_kana'  => 'required|max:255|hiragana',
            'postal_code' => 'required|max:8',
            'address' => 'required|max:255',
            'phone_number' => 'required|max:13',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'type' => [
                'required',
                Rule::in(ShelterType::values()),
            ],
            'target_disaster_types' => 'required|array',
            'target_disaster_types.*' => Rule::in(DisasterType::values()),
            'capacity' => 'required|integer|min:1',
            'facility_info' => 'nullable|max:1000',
            'staff_user_id' => 'required|exists:staff_users,id',
        ];
    }

    public function messages()
    {
        return [
            'images.*.base64' => ':attributeの形式が正しくありません',
            'images.*.base64_ext_in' => 'サポートされている:attributeの拡張子は:extsです',
            'images.*.base64_max' => ':attributeの最大サイズは:maxMBです',
            'name.required' => ':attributeは必須です',
            'name.max'  => ':attributeが長すぎます',
            'name_kana.required' => ':attributeは必須です',
            'name_kana.max'  => ':attributeが長すぎます',
            'name_kana.hiragana'  => ':attributeはひらがなで入力してください',
            'postal_code.required' => ':attributeは必須です',
            'postal_code.max'  => ':attributeは8文字以下で入力してください',
            'address.required' => ':attributeは必須です',
            'address.max'  => ':attributeが長すぎます',
            'phone_number.required' => ':attributeは必須です',
            'phone_number.max'  => ':attributeが長すぎます',
            'latitude.required' => ':attributeは必須です',
            'latitude.numeric'  => ':attributeは数値で指定してください',
            'longitude.required' => ':attributeは必須です',
            'longitude.numeric'  => ':attributeは数値で指定してください',
            'type.required' => ':attributeは必須です',
            'type.in' => ':attributeの形式が正しくありません',
            'target_disaster_types.required' => ':attributeは必須です',
            'target_disaster_types.array' => ':attributeは配列で指定してください',
            'target_disaster_types.*.in' => ':attributeの形式が正しくありません',
            'capacity.required' => ':attributeは必須です',
            'capacity.integer'  => ':attributeは数値で指定してください',
            'capacity.min'  => ':attributeは1以上で指定してください',
            'facility_info.required' => ':attributeは必須です',
            'facility_info.max'  => ':attributeが長すぎます',
            'staff_user_id.required' => ':attributeは必須です',
            'staff_user_id.exists' => '指定された:attributeは存在しません',
        ];
    }

    public function attributes()
    {
        return [
            'images' => '避難所画像',
            'images.*' => '画像',
            'name' => '避難所名',
            'name_kana' => '避難所名(かな)',
            'postal_code' => '郵便番号',
            'address' => '所在地',
            'phone_number' => '電話番号',
            'latitude' => '所在地(緯度)',
            'longitude' => '所在地(経度)',
            'type' => '避難所種別',
            'target_disaster_types' => '対象とする異常な現象の種類',
            'capacity' => '最大収容人数',
            'facility_info' => '設備情報',
            'staff_user_id' => '責任者',
        ];
    }
}
