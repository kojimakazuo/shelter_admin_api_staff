<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class HomeCollection extends ResourceCollection
{
    public static $wrap = NULL;

    public function toArray($request)
    {
        return [
            'disaster' => new HomeDisasterResource($this->collection['disaster']),
        ];
    }
}
