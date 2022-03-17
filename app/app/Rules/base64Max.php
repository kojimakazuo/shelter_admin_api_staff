<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * Base64サイズチェック
 */
class Base64Max implements Rule
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
        preg_match('/data:image\/\w+.*;base64,(.*)/u', $value, $matches);
        if (!isset($matches[1])) return false;
        return strlen(base64_decode($matches[1])) <= ($parameters[0] * 1000 * 1000);
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

    /**
     * Replace placeholder
     */
    public function replacer($message, $attribute, $rule, $parameters)
    {
        return str_replace([':max'], [$parameters[0]], $message);
    }
}
