<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DisasterEntrySheetWebResource extends JsonResource
{
    public static $wrap = null;

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'entry_sheet_id' => $this->entry_sheet_id,
            'birthday' => $this->birthday->format('Y-m-d'),
            'gender' => $this->gender,
            'postal_code' => $this->postal_code,
            'address' => $this->address,
            'phone_number' => $this->phone_number,
            'companion' => $this->companion,
            'stay_in_car' => $this->stay_in_car,
            'number_of_in_car' => $this->number_of_in_car,
            'temperature' => $this->temperature,
            'has_companion' => count($this->companions) > 0,
            'companions' => DisasterEntrySheetWebCompanionResource::collection($this->companions),
            'enquetes' => $this->enquete->data,
        ];
    }
}
