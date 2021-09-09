<?php

namespace App\Http\Requests;

use App\Enums\Gender;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DisasterEntrySheetPaperRequest extends FormRequest
{
    public function rules()
    {
        return [
            'sheet_number'  => 'required|integer',
            'name'  => 'required|max:255',
            'name_kana'  => 'required|max:255|hiragana',
            'gender' => ['required', Rule::in(Gender::values())],
            'temperature' => 'required|numeric',
            'companions'  => 'array',
            'companions.*.id'  => 'integer',
            'companions.*.gender' => ['required', Rule::in(Gender::values())],
            'companions.*.temperature' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'sheet_number.required' => ':attributeは必須です',
            'sheet_number.integer'  => ':attributeは数値で指定してください',
            'name.required' => ':attributeは必須です',
            'name.max'  => ':attributeが長すぎます',
            'name_kana.required' => ':attributeは必須です',
            'name_kana.max'  => ':attributeが長すぎます',
            'name_kana.hiragana'  => ':attributeはひらがなで入力してください',
            'gender.required' => ':attributeは必須です',
            'gender.in' => ':attributeの形式が正しくありません',
            'temperature.required' => ':attributeは必須です',
            'temperature.numeric'  => ':attributeは数値で指定してください',
            'companions.*.gender.required' => ':attributeは必須です',
            'companions.*.gender.in' => ':attributeの形式が正しくありません',
            'companions.*.temperature.required' => ':attributeは必須です',
            'companions.*.temperature.numeric'  => ':attributeは数値で指定してください',
        ];
    }

    public function attributes()
    {
        return [
            'sheet_number' => '管理番号',
            'name' => '代表者氏名',
            'name_kana' => '代表者氏名(かな)',
            'gender' => '性別',
            'temperature' => '代表者体温',
            'companions.*.gender' => '同行者性別',
            'companions.*.temperature' => '同行者体温',
        ];
    }

    protected function passedValidation()
    {
        // 同行者が同居家族以外の場合は同居家族の情報を空にする
        if (!$this->companions) {
            $this->merge(['companions' => []]);
        }
    }

    public function fillable()
    {
        return $this->only([
            'sheet_number',
            'name',
            'name_kana',
            'gender',
            'temperature',
            'companions',
        ]);
    }
}
