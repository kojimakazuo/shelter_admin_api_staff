<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShelterResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'name_kana' => $this->name_kana,
            'postal_code' => $this->postal_code,
            'address' => $this->address,
            'phone_number' => $this->phone_number,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'type' => $this->type,
            'target_disaster_type' => $this->target_disaster_type,
            'capacity' => $this->capacity,
            'facility_info' => $this->facility_info,
            'staff_user_id' => $this->staff_user_id,
        ];
    }
}
