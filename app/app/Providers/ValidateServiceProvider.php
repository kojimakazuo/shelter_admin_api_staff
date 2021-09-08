<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class ValidateServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        /** ひらがな */
        Validator::extend('hiragana', function ($attribute, $value, $parameters, $validator) {
            return !preg_match('/[^ぁ-んー\s]/u', $value);
        });

        /**
         * Base64 & ImageType
         * 形式: data:image/png;base64,XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX==
         */
        Validator::extend('base64_image', function ($attribute, $value, $parameters, $validator) {
            preg_match('/data:image\/(\w+);base64,(.*)/u', $value, $matches);
            if (count($matches) < 3) {
                // 形式エラー
                return false;
            }
            $type = $matches[1];
            if (!(strcmp($type, 'jpeg') == 0 || strcmp($type, 'jpg') == 0 || strcmp($type, 'png') == 0)) {
                // jpeg, png以外の場合はエラー
                return false;
            }
            $data = $matches[2];
            if (strlen($data) > (20 * 1000 * 1000)) {
                // 20MB以上の場合はエラー
                return false;
            }
            return true;
        });
    }
}
