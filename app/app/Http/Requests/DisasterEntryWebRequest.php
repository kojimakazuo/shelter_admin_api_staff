<?php

namespace App\Http\Requests;

use App\Enums\EntrySiteType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DisasterEntryWebRequest extends FormRequest
{
    public function rules()
    {
        return [
            'disaster_shelter_id'  => 'required|exists:disaster_shelters,id',
            'entry_sheet_id'  => 'required|exists:entry_sheets,id',
            'site_type' => [
                'required',
                Rule::in(EntrySiteType::values()),
            ],
            'temperature' => 'required|numeric',
            'companions' => 'array',
            'companions.*.id' => 'required|distinct|exists:entry_sheet_web_companions,id',
            'companions.*.temperature' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'disaster_shelter_id.required' => ':attributeは必須です',
            'disaster_shelter_id.exists' => ':attributeの指定が正しくありません',
            'entry_sheet_id.required' => ':attributeは必須です',
            'entry_sheet_id.exists' => ':attributeの指定が正しくありません',
            'title.max'  => ':attributeが長すぎます',
            'site_type.required' => ':attributeは必須です',
            'site_type.in' => ':attributeの形式が正しくありません',
            'temperature.required' => ':attributeは必須です',
            'temperature.numeric'  => ':attributeは数値で指定してください',
            'companions.*.id.required' => ':attributeは必須です',
            'companions.*.id.distinct' => ':attributeが重複しています',
            'companions.*.id.exists' => ':attributeの指定が正しくありません',
            'companions.*.temperature.required' => ':attributeは必須です',
            'companions.*.temperature.numeric'  => ':attributeは数値で指定してください',
        ];
    }

    public function attributes()
    {
        return [
            'disaster_shelter_id' => '災害避難所ID',
            'entry_sheet_id' => '受付シートID',
            'site_type'  => '避難場所',
            'temperature' => '代表者体温',
            'companions.*.id' => '同行者ID',
            'companions.*.temperature' => '同行者体温',
        ];
    }

    public function fillable()
    {
        return $this->only([
            'disaster_shelter_id',
            'entry_sheet_id',
            'site_type',
            'temperature',
            'companions',
        ]);
    }
}
