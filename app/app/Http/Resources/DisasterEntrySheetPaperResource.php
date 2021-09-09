<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DisasterEntrySheetPaperResource extends JsonResource
{
    public static $wrap = null;

    public function toArray($request)
    {
        $paper = $this->paper;
        return [
            'id' => $this->id,
            'disaster_id' => $this->disaster_id,
            'type' => $this->type,
            'name' => $this->name,
            'name_kana' => $this->name_kana,
            'sheet_number' => $paper->sheet_number,
            'gender' => $paper->gender,
            'temperature' => $paper->temperature,
            'front_sheet_image_url' => $paper->pre_signed_front_sheet_image_url(),
            'back_sheet_image_url' => $paper->pre_signed_back_sheet_image_url(),
            'has_companion' => count($paper->companions) > 0,
            'companions' => DisasterEntrySheetPaperCompanionResource::collection($paper->companions),
        ];
    }
}
