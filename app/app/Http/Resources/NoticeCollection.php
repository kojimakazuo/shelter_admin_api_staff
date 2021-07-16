<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class NoticeCollection extends ResourceCollection
{
    public static $wrap = null;

    public function toArray($request)
    {
        return [
            'notices' => NoticeResource::collection($this->collection['notices']),
        ];
    }
}
