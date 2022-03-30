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
        Validator::extend('hiragana', 'App\Rules\Hiragana@passes');
        Validator::extend('base64', 'App\Rules\Base64@passes');
        Validator::extend('base64_ext_in', 'App\Rules\Base64ExtIn@passes');
        Validator::replacer('base64_ext_in', 'App\Rules\Base64ExtIn@replacer');
        Validator::extend('base64_max', 'App\Rules\base64Max@passes');
        Validator::replacer('base64_max', 'App\Rules\base64Max@replacer');
    }
}
