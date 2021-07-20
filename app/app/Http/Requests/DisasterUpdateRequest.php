<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DisasterUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title'  => 'required|max:255',
            'start_at' => 'required|date_format:Y-m-d\TH:i:s',
            'end_at' => 'nullable|date_format:Y-m-d\TH:i:s',
            'disaster_shelters' => 'required|array',
            'disaster_shelters.*.id' => [
                'nullable',
                'distinct',
                Rule::exists('disaster_shelters', 'id')->where(function ($query) {
                    $query->where('disaster_id', $this->id);
                }),
            ],
            'disaster_shelters.*.capacity' => 'required|integer|min:1',
            'disaster_shelters.*.staff_user_id' => 'required|exists:staff_users,id',
            'disaster_shelters.*.shelter_id' => 'required_if:disaster_shelters.*.id,null|exists:shelters,id',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => ':attributeは必須です',
            'title.max'  => ':attributeが長すぎます',
            'start_at.required' => ':attributeは必須です',
            'start_at.date_format' => ':attributeの形式が正しくありません',
            'end_at.date_format' => ':attributeの形式が正しくありません',
            'disaster_shelters.required' => ':attributeは必須です',
            'disaster_shelters.*.id.required' => ':attributeは必須です',
            'disaster_shelters.*.id.distinct' => ':attributeが重複しています',
            'disaster_shelters.*.id.exists' => ':attributeの指定が正しくありません',
            'disaster_shelters.*.capacity.required' => ':attributeは必須です',
            'disaster_shelters.*.capacity.integer'  => ':attributeは数値で指定してください',
            'disaster_shelters.*.capacity.min'  => ':attributeは1以上で指定してください',
            'disaster_shelters.*.staff_user_id.required' => ':attributeは必須です',
            'disaster_shelters.*.staff_user_id.exists' => ':attributeの指定が正しくありません',
            'disaster_shelters.*.shelter_id.required_if' => 'idがnullの場合は:attributeは必須です',
            'disaster_shelters.*.shelter_id.exists' => ':attributeの指定が正しくありません',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'タイトル',
            'start_at' => '開始日時',
            'end_at'  => '終了日時',
            'disaster_shelters' => '避難所',
            'disaster_shelters.*.id' => '災害避難所ID',
            'disaster_shelters.*.capacity' => '収容人数',
            'disaster_shelters.*.staff_user_id' => '担当者',
            'disaster_shelters.*.shelter_id' => '避難所ID',
        ];
    }

    public function fillable()
    {
        return $this->only([
            'title',
            'start_at',
            'end_at',
            'disaster_shelters',
            'disaster_shelters.id',
            'disaster_shelters.capacity',
            'disaster_shelters.staff_user_id',
            'disaster_shelters.shelter_id',
        ]);
    }
}
