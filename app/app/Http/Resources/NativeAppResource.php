<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NativeAppResource extends JsonResource
{
    public static $wrap = null;

    public function toArray($request)
    {
        return [
            'android_app' => new AndroidAppResource($this['android_app']),
        ];
    }
}
