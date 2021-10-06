<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NativeAppAndroidDownloadUrlResource extends JsonResource
{
    public static $wrap = null;

    public function toArray($request)
    {
        return [
            'download_url' => $this['download_url'],
        ];
    }
}
