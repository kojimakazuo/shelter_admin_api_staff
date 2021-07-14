<?php

return [

    'token' => [
        'key' => 'token',
        'expire' => 20160,
        'path' => null,
        'domain' => null,
        'scheme' => env('COOKIE_SCHEME', 'https'),
        'http_only' => true,
    ],

];
