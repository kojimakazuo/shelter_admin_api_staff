<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DisasterShelterResource extends JsonResource
{
    public static $wrap = null;

    public function toArray($request)
    {
        $shelter = $this->shelter;
        return [
            'id' => $this->id,
            'capacity' => $this->capacity,
            'staff_user' => new StaffUserResource($this->staffUser),
            'shelter' => new ShelterResource($shelter),
        ];
    }
}
