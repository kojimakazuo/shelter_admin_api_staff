<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class FacilityCollection extends ResourceCollection
{
    public static $wrap = null;

    public function toArray($request)
    {
        return [
            'facilities' => FacilityResource::collection($this->collection['facilities']),
        ];
    }
}
