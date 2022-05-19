<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * Base64チェック
 */
class Base64 implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        preg_match('/data:image\/([\w\+]+);base64,(.*)/u', $value, $matches);
        return count($matches) === 3;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return null;
    }
}
