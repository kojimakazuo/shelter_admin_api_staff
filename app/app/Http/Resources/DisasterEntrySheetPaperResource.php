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
            'gender' => $paper->gender,
            'temperature' => $paper->temperature,
            'companions' => DisasterEntrySheetPaperCompanionResource::collection($paper->companions),
        ];
    }
}
