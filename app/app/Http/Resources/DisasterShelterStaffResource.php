<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DisasterShelterStaffsResource extends JsonResource
{
    public static $wrap = null;

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'staff_user' => new StaffUserResource($this->staffUser),
            //'disaster_shelters' => new DisasterShelterResource($this->shelter),
        ];
    }
}
