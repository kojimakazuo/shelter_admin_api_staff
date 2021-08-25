<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class DisasterEntrySearchRequest extends FormRequest
{
    public function rules()
    {
        return [
            'disaster_shelter_id' => 'integer',
            'entered_at_from' => 'date_format:Y-m-d\TH:i:s',
            'name_kana'  => 'hiragana',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        // 検索はQueryParamが不正でもエラー扱いとはしないためOverride
    }

    public function formattedQueryParams(): array
    {
        return $this->except(array_keys($this->validator->failed()));
    }
}
