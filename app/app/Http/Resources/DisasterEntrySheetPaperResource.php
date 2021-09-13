<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DisasterEntrySheetPaperResource extends JsonResource
{
    public static $wrap = null;

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'entry_sheet_id' => $this->entry_sheet_id,
            'sheet_number' => $this->sheet_number,
            'gender' => $this->gender,
            'temperature' => $this->temperature,
            'front_sheet_image_url' => $this->pre_signed_front_sheet_image_url(),
            'back_sheet_image_url' => $this->pre_signed_back_sheet_image_url(),
            'has_companion' => count($this->companions) > 0,
            'companions' => DisasterEntrySheetPaperCompanionResource::collection($this->companions),
        ];
    }
}
