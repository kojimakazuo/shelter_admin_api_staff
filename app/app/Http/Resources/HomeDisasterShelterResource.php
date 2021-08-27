<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HomeDisasterShelterResource extends JsonResource
{
    public static $wrap = null;

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'capacity' => $this->capacity,
            'number_of_entries' => count($this->entries),
            'staff_user' => new StaffUserResource($this->staffUser),
            'shelter' => new ShelterResource($this->shelter),
        ];
    }
}
