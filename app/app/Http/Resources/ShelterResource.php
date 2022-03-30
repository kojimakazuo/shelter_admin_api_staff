<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShelterResource extends JsonResource
{
    public static $wrap = null;

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'images' => ShelterImageResource::collection($this->shelterImages),
            'name' => $this->name,
            'name_kana' => $this->name_kana,
            'postal_code' => $this->postal_code,
            'address' => $this->address,
            'phone_number' => $this->phone_number,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'type' => $this->type,
            'target_disaster_types' => $this->target_disaster_types,
            'capacity' => $this->capacity,
            'shelter_facilities' => ShelterFacilityResource::collection($this->shelterFacilities),
            'facility_info' => $this->facility_info,
            'staff_user' => new StaffUserResource($this->staffUser),
        ];
    }
}
