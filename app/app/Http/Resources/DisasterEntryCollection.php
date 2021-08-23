<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DisasterEntryCollection extends ResourceCollection
{
    public static $wrap = null;

    public function toArray($request)
    {
        return [
            'entries' => DisasterEntryResource::collection($this->collection['entries']),
        ];
    }
}
