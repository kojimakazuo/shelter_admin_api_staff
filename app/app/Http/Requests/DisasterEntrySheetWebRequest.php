<?php

namespace App\Http\Requests;

use App\Enums\EntryCompanionType;
use App\Enums\Gender;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DisasterEntrySheetWebRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name'  => 'nullable|max:255',
            'name_kana'  => 'required|max:255|hiragana',
            'temperature' => 'nullable|numeric',
            'postal_code' => 'required|max:8',
            'address' => 'required|max:255',
            'phone_number' => 'required|max:13',
            'birthday' => 'required|date_format:Y-m-d',
            'gender' => ['required', Rule::in(Gender::values())],
            'companion' => ['required', Rule::in(EntryCompanionType::values())],
            'stay_in_car' => 'required|boolean',
            'number_of_in_car' => 'required_if:stay_in_car,true|nullable|integer|min:1',
            'companions'  => 'nullable|array',
            'companions.*.id'  => 'integer',
            'companions.*.name'  => 'nullable|max:255',
            'companions.*.name_kana'  => 'required|max:255|hiragana',
            'companions.*.temperature' => 'nullable|numeric',
            'companions.*.birthday' => 'required|date_format:Y-m-d',
            'companions.*.gender' => ['required', Rule::in(Gender::values())],
            'enquetes.health'  => 'required|array',
            'enquetes.home'  => 'required|array',
        ];
    }

    public function messages()
    {
        return [
            'name.max'  => ':attributeが長すぎます',
            'name_kana.required' => ':attributeは必須です',
            'name_kana.max'  => ':attributeが長すぎます',
            'name_kana.hiragana'  => ':attributeはひらがなで入力してください',
            'temperature.numeric'  => ':attributeは数値で指定してください',
            'postal_code.required' => ':attributeは必須です',
            'postal_code.max'  => ':attributeは8文字以下で入力してください',
            'address.required' => ':attributeは必須です',
            'address.max'  => ':attributeが長すぎます',
            'phone_number.required' => ':attributeは必須です',
            'phone_number.max'  => ':attributeが長すぎます',
            'birthday.required' => ':attributeは必須です',
            'birthday.date_format' => ':attributeの形式が正しくありません',
            'gender.required' => ':attributeは必須です',
            'gender.in' => ':attributeの形式が正しくありません',
            'companion.required' => ':attributeは必須です',
            'companion.in' => ':attributeの形式が正しくありません',
            'stay_in_car.required' => ':attributeは必須です',
            'stay_in_car.boolean' => ':attributeの形式が正しくありません',
            'number_of_in_car.required_if' => '車中避難を選択した場合は:attributeは必須です',
            'number_of_in_car.integer'  => ':attributeは数値で指定してください',
            'number_of_in_car.min'  => ':attributeは1以上で指定してください',
            'companions.*.name.max'  => ':attributeが長すぎます',
            'companions.*.name_kana.required' => ':attributeは必須です',
            'companions.*.name_kana.max'  => ':attributeが長すぎます',
            'companions.*.name_kana.hiragana'  => ':attributeはひらがなで入力してください',
            'companions.*.temperature.numeric'  => ':attributeは数値で指定してください',
            'companions.*.birthday.required' => ':attributeは必須です',
            'companions.*.birthday.date_format' => ':attributeの形式が正しくありません',
            'companions.*.gender.required' => ':attributeは必須です',
            'companions.*.gender.in' => ':attributeの形式が正しくありません',
            'enquetes.health.required'  => ':attributeは必須です',
            'enquetes.health.array' => ':attributeの形式が正しくありません',
            'enquetes.home.required'  => ':attributeは必須です',
            'enquetes.home.array' => ':attributeの形式が正しくありません',
        ];
    }

    public function attributes()
    {
        return [
            'name' => '代表者氏名',
            'name_kana' => '代表者氏名(かな)',
            'temperature' => '代表者体温',
            'postal_code' => '郵便番号',
            'address' => '住所',
            'phone_number' => '電話番号',
            'birthday' => '生年月日',
            'gender' => '性別',
            'companion' => '同行者',
            'stay_in_car' => '車中避難',
            'number_of_in_car' => '車中避難者人数',
            'companions.*.name'  => '同居家族氏名',
            'companions.*.name_kana' => '同居家族氏名(かな)',
            'companions.*.temperature' => '同行者体温',
            'companions.*.birthday' => '同居家族生年月日',
            'companions.*.gender' => '同居家族性別',
            'enquetes.health'  => '健康について',
            'enquetes.home' => '自宅等の情報',
        ];
    }

    protected function passedValidation()
    {
        // 車中避難をしない場合は車中人数をnullにする
        if (!$this->stay_in_car) {
            $this->merge(['number_of_in_car' => null]);
        }
        // 同行者が同居家族以外の場合は同居家族の情報を空にする
        if (new EntryCompanionType($this->companion) != EntryCompanionType::FAMILY) {
            $this->merge(['companions' => []]);
        }
    }

    public function fillable()
    {
        return $this->only([
            'name',
            'name_kana',
            'temperature',
            'postal_code',
            'address',
            'phone_number',
            'birthday',
            'gender',
            'companion',
            'stay_in_car',
            'number_of_in_car',
            'companions',
            'enquetes',
        ]);
    }
}
