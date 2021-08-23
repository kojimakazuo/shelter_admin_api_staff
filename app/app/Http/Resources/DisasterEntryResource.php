<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DisasterEntryResource extends JsonResource
{
    public static $wrap = null;

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'disaster_shelter' => new DisasterShelterResource($this->disasterShelter),
            'entry_sheet_id' => $this->entry_sheet_id,
            'enterd_at' => $this->enterd_at->format('Y-m-d\TH:i:s'),
            'exited_at' => optional($this->exited_at)->format('Y-m-d\TH:i:s'),
            'site_type' => $this->site_type,
            'entry_sheet' => new DisasterEntrySheetResource($this->entrySheet),
        ];
    }
}
