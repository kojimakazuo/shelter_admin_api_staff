<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class APIResponseServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * API Response JSON
     *
     * @return void
     */
    public function boot()
    {
        // 400: Bad Request
        Response::macro('badrequest', function ($code, $message) {
            return Response::json([
                'code' => $code,
                'message' => $message,
            ], 400);
        });
        // 401: Unauthorized
        Response::macro('unauthorized', function () {
            return Response::json([], 401);
        });
        // 404: Not Found
        Response::macro('notfound', function () {
            return Response::json([], 404);
        });
    }
}
