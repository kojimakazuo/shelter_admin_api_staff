<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * Base64拡張子チェック
 */
class Base64ExtIn implements Rule
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
    public function passes($attribute, $value, $parameters = [])
    {
        preg_match('/data:image\/(\w+).*;base64,.*/u', $value, $matches);
        if (!isset($matches[1])) return false;
        return in_array($matches[1], $parameters, true);
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

    public function replacer($message, $attribute, $rule, $parameters)
    {
        return str_replace([':exts'], [implode(", ", $parameters)], $message);
    }
}
