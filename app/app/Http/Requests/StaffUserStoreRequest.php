<?php

namespace App\Http\Requests;

use App\Enums\StaffRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StaffUserStoreRequest extends FormRequest
{
    public function rules()
    {
        $rules = [
            'password'  => 'nullable|min:8|max:24',
            'name'  => 'required|max:255',
            'name_kana'  => 'required|max:255|hiragana',
            'phone_number' => 'required|max:13',
            'role' => [
                'required',
                Rule::in(StaffRole::values()),
            ],
        ];
        if ($this->method() == 'POST') {
            // 新規登録の場合のみlogin_idをチェック(login_idは更新不可)
            $rules['login_id'] = 'required|unique:staff_users,login_id';
            // 新規登録の場合のみpasswordは必須
            $rules['password'] = 'required|min:8|max:24';
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'login_id.required' => ':attributeは必須です',
            'login_id.unique' => ':attributeはすでに存在しています',
            'password.required' => ':attributeは必須です',
            'password.min'  => ':attributeは8文字以上で入力してください',
            'password.max'  => ':attributeは24文字以下で入力してください',
            'name.required' => ':attributeは必須です',
            'name.max'  => ':attributeが長すぎます',
            'name_kana.required' => ':attributeは必須です',
            'name_kana.max'  => ':attributeが長すぎます',
            'name_kana.hiragana'  => ':attributeはひらがなで入力してください',
            'phone_number.required' => ':attributeは必須です',
            'phone_number.max'  => ':attributeが長すぎます',
            'role.required' => ':attributeは必須です',
            'role.in' => ':attributeの形式が正しくありません',
        ];
    }

    public function attributes()
    {
        return [
            'login_id' => 'ログインID',
            'password' => 'パスワード',
            'name' => '氏名',
            'name_kana' => '氏名(かな)',
            'phone_number' => '電話番号',
            'role' => '役割',
        ];
    }

    public function fillable()
    {
        $values = [
            'password',
            'name',
            'name_kana',
            'phone_number',
            'role',
        ];
        if ($this->method() == 'POST') {
            $values[] = 'login_id';
        }
        return $this->only($values);
    }
}
