<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DisasterShelterResource extends JsonResource
{
    public static $wrap = null;

    public function toArray($request)
    {
        $number_of_entries = count($this->entries);
        return [
            'id' => $this->id,
            'capacity' => $this->capacity,
            'number_of_entries' => $number_of_entries,
            'remaining_number_of_capacities' => $this->capacity - $number_of_entries,
            'entry_rate' => floor(($number_of_entries / $this->capacity * 100) * 100) / 100,
            'capacity' => $this->capacity,
            'staff_user' => new StaffUserResource($this->staffUser),
            'shelter' => new ShelterResource($this->shelter),
        ];
    }
}
