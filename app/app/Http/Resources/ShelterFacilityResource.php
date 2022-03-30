<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShelterFacilityResource extends JsonResource
{
    public static $wrap = null;

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'shelter_id' => $this->shelter_id,
            'facility_id' => $this->facility_id,
            'order' => $this->order,
            'facility' => new FacilityResource($this->facility),
        ];
    }
}
