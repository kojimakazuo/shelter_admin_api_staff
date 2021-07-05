<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ShelterCollection extends ResourceCollection
{
    public static $wrap = null;

    public function toArray($request)
    {
        return [
            'shelters' => ShelterResource::collection($this->collection['shelters']),
        ];
    }
}
