<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DisasterShelterStaffsUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'start_at' => 'required|date_format:Y-m-d\TH:i:s',
            'end_at' => 'nullable|date_format:Y-m-d\TH:i:s',
            'disatser_shelter_staffs' => 'required|array',
            'disatser_shelter_staffs.*.id' => [
                'nullable',
                'distinct',
                Rule::exists('disatser_shelter_staffs', 'id')->where(function ($query) {
                    $query->where('disatser_shelter_staffs', $this->id);
                }),
            ],
            'disatser_shelter_staffs.*.staff_user_id' => 'required|exists:staff_users,id',
            'disatser_shelter_staffs.*.disater_id' => 'required|exists:disaters,id',
            'disatser_shelter_staffs.*.shelter_id' => 'required|exists:shelters,id',
        ];
    }

    public function messages()
    {
        return [
            'start_at.required' => ':attributeは必須です',
            'start_at.date_format' => ':attributeの形式が正しくありません',
            'end_at.date_format' => ':attributeの形式が正しくありません',
            'disatser_shelter_staffs.required' => ':attributeは必須です',
            'disatser_shelter_staffs.*.id.distinct' => ':attributeが重複しています',
            'disatser_shelter_staffs.*.id.exists' => ':attributeの指定が正しくありません',
            'disatser_shelter_staffs.*.staff_user_id.required' => ':attributeは必須です',
            'disatser_shelter_staffs.*.staff_user_id.exists' => ':attributeの指定が正しくありません',
            'disatser_shelter_staffs.*.disater_id.required_if' => 'idがnullの場合は:attributeは必須です',
            'disatser_shelter_staffs.*.disater_id.exists' => ':attributeの指定が正しくありません',
            'disatser_shelter_staffs.*.shelter_id.required_if' => 'idがnullの場合は:attributeは必須です',
            'disatser_shelter_staffs.*.shelter_id.exists' => ':attributeの指定が正しくありません',
        ];
    }

    public function attributes()
    {
        return [
            'start_at' => '開始日時',
            'end_at'  => '終了日時',
            'disatser_shelter_staffs' => '開設避難所職員',
            'disatser_shelter_staffs.*.id' => '開設避難所職員ID',
            'disatser_shelter_staffs.*.staff_user_id' => '担当者',
            'disatser_shelter_staffs.*.disater_id' => '災害ID',
            'disatser_shelter_staffs.*.shelter_id' => '避難所ID',
        ];
    }

    public function fillable()
    {
        return $this->only([
            'start_at',
            'end_at',
            'disatser_shelter_staffs',
            'disatser_shelter_staffs.id',
            'disatser_shelter_staffs.staff_user_id',
            'disatser_shelter_staffs.disater_id',
            'disatser_shelter_staffs.shelter_id',
        ]);
    }
}
