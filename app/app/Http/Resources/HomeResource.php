<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class HomeResource extends ResourceCollection
{
    public static $wrap = NULL;

    public function toArray($request)
    {
        return [
            'municipality' => new MunicipalityResource($this['municipality']),
            'disaster' => new HomeDisasterResource($this['disaster']),
        ];
    }
}
