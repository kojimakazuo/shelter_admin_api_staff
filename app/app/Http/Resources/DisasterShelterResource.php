<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DisasterShelterResource extends JsonResource
{
    public static $wrap = null;

    public function toArray($request)
    {
        $number_of_evacuees = $this->numberOfEvacuees();
        return [
            'id' => $this->id,
            'capacity' => $this->capacity,
            'number_of_evacuees' => $number_of_evacuees,
            'remaining_number_of_capacities' => $this->capacity - $number_of_evacuees,
            'evacuee_rate' => floor(($number_of_evacuees / $this->capacity * 100) * 100) / 100,
            'staff_user' => new StaffUserResource($this->staffUser),
            'condition' => $this->condition,
            'shelter' => new ShelterResource($this->shelter),
        ];
    }
}
