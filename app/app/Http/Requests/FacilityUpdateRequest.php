<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FacilityUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name'  => 'required|max:255',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => ':attributeは必須です',
            'name.max'  => ':attributeが長すぎます',
        ];
    }

    public function attributes()
    {
        return [
            'name' => '設備名称',
        ];
    }
}
