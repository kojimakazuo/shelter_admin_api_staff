<?php

namespace App\Http\Requests;

use App\Enums\EntrySiteType;
use App\Enums\Gender;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DisasterEntryPaperRequest extends FormRequest
{
    public function rules()
    {
        return [
            'disaster_shelter_id'  => 'required|exists:disaster_shelters,id',
            'front_image'  => 'required|base64|base64_ext_in:jpeg,jpg,png|base64_max:10',
            'back_image'  => 'nullable|base64|base64_ext_in:jpeg,jpg,png|base64_max:10',
            'sheet_number'  => 'required|integer',
            'site_type' => [
                'required',
                Rule::in(EntrySiteType::values()),
            ],
            'name'  => 'nullable|max:255',
            'name_kana'  => 'required|max:255|hiragana',
            'gender' => ['required', Rule::in(Gender::values())],
            'temperature' => 'nullable|numeric',
            'companions' => 'array',
            'companions.*.gender' => ['required', Rule::in(Gender::values())],
            'companions.*.temperature' => 'nullable|numeric',
        ];
    }

    public function messages()
    {
        return [
            'disaster_shelter_id.required' => ':attributeは必須です',
            'disaster_shelter_id.exists' => ':attributeの指定が正しくありません',
            'front_image.base64' => ':attributeの形式が正しくありません',
            'front_image.base64_ext_in' => 'サポートされている:attributeの拡張子は:extsです',
            'front_image.base64_max' => ':attributeの最大サイズは:maxMBです',
            'back_image.base64' => ':attributeの形式が正しくありません',
            'back_image.base64_ext_in' => 'サポートされている:attributeの拡張子は:extsです',
            'back_image.base64_max' => ':attributeの最大サイズは:maxMBです',
            'sheet_number.required' => ':attributeは必須です',
            'sheet_number.integer' => ':attributeは数値で指定してください',
            'title.max'  => ':attributeが長すぎます',
            'site_type.required' => ':attributeは必須です',
            'site_type.in' => ':attributeの形式が正しくありません',
            'name.max'  => ':attributeが長すぎます',
            'name_kana.required' => ':attributeは必須です',
            'name_kana.max'  => ':attributeが長すぎます',
            'name_kana.hiragana'  => ':attributeはひらがなで入力してください',
            'gender.required' => ':attributeは必須です',
            'gender.in' => ':attributeの形式が正しくありません',
            'temperature.numeric'  => ':attributeは数値で指定してください',
            'companions.*.gender.required' => ':attributeは必須です',
            'companions.*.gender.in' => ':attributeの形式が正しくありません',
            'companions.*.temperature.numeric'  => ':attributeは数値で指定してください',
        ];
    }

    public function attributes()
    {
        return [
            'disaster_shelter_id' => '災害避難所ID',
            'front_image' => 'チェックシート(表面)',
            'back_image' => 'チェックシート(裏面)',
            'sheet_number' => '管理番号',
            'site_type'  => '避難場所',
            'name' => '代表者氏名',
            'name_kana' => '代表者氏名(かな)',
            'gender' => '代表者性別',
            'temperature' => '代表者体温',
            'companions.*.id' => '同行者ID',
            'companions.*.gender' => '同居家族性別',
            'companions.*.temperature' => '同行者体温',
        ];
    }

    public function fillable()
    {
        return $this->only([
            'disaster_shelter_id',
            'front_image',
            'back_image',
            'sheet_number',
            'site_type',
            'name',
            'name_kana',
            'gender',
            'temperature',
            'companions',
        ]);
    }
}
