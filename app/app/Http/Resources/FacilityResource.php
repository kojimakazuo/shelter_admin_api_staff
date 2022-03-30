<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FacilityResource extends JsonResource
{
    public static $wrap = null;

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'image_url' => $this->imageUrl(),
            'name' => $this->name,
        ];
    }
}
