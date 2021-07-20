<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DisasterStoreRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title'  => 'required|max:255',
            'start_at' => 'required|date_format:Y-m-d\TH:i:s',
            'end_at' => 'nullable|date_format:Y-m-d\TH:i:s',
            'shelters' => 'required|array',
            'shelters.*.id' => 'required|distinct|exists:shelters,id',
            'shelters.*.capacity' => 'required|integer|min:1',
            'shelters.*.staff_user_id' => 'required|exists:staff_users,id',
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
            'shelters.required' => ':attributeは必須です',
            'shelters.*.id.required' => ':attributeは必須です',
            'shelters.*.id.distinct' => ':attributeが重複しています',
            'shelters.*.id.exists' => ':attributeの指定が正しくありません',
            'shelters.*.capacity.required' => ':attributeは必須です',
            'shelters.*.capacity.integer'  => ':attributeは数値で指定してください',
            'shelters.*.capacity.min'  => ':attributeは1以上で指定してください',
            'shelters.*.staff_user_id.required' => ':attributeは必須です',
            'shelters.*.staff_user_id.exists' => ':attributeの指定が正しくありません',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'タイトル',
            'start_at' => '開始日時',
            'end_at'  => '終了日時',
            'shelters' => '避難所',
            'shelters.*.id' => '避難所ID',
            'shelters.*.capacity' => '収容人数',
            'shelters.*.staff_user_id' => '担当者',
        ];
    }

    public function fillable()
    {
        return $this->only([
            'title',
            'start_at',
            'end_at',
            'shelters',
            'shelters.id',
            'shelters.capacity',
            'shelters.staff_user_id',
        ]);
    }
}
