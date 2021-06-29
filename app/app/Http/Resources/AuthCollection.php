<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AuthCollection extends ResourceCollection
{
    public static $wrap = NULL;

    public function toArray($request)
    {
        return [
            'access_token' => $this->collection['access_token'],
            'token_type' => $this->collection['token_type'],
            'expires_in' => $this->collection['expires_in'],
            'user' => new StaffUserResource($this->collection['user']),
        ];
    }
}
