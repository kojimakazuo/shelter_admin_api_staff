<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DisasterEntrySheetWebResource extends JsonResource
{
    public static $wrap = null;

    public function toArray($request)
    {
        $web = $this->web;
        return [
            'id' => $this->id,
            'disaster_id' => $this->disaster_id,
            'type' => $this->type,
            'name' => $this->name,
            'name_kana' => $this->name_kana,
            'birthday' => $web->birthday->format('Y-m-d'),
            'gender' => $web->gender,
            'postal_code' => $web->postal_code,
            'address' => $web->address,
            'phone_number' => $web->phone_number,
            'companion' => $web->companion,
            'companions' => DisasterEntrySheetWebCompanionResource::collection($web->companions),
        ];
    }
}
