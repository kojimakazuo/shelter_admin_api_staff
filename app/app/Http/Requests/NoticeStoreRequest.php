<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NoticeStoreRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title'  => 'required|max:255',
            'body'  => 'required|max:1000',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => ':attributeは必須です',
            'name.max'  => ':attributeが長すぎます',
            'body.required' => ':attributeは必須です',
            'body.max'  => ':attributeが長すぎます',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'タイトル',
            'body' => '本文',
        ];
    }

    public function fillable()
    {
        return $this->only([
            'title',
            'body',
        ]);
    }
}
