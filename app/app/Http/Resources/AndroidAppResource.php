<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AndroidAppResource extends JsonResource
{
    public static $wrap = null;

    public function toArray($request)
    {
        return [
            'paths' => $this->paths,
        ];
    }
}
