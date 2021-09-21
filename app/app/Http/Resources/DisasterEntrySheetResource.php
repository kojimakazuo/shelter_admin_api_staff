<?php

namespace App\Http\Resources;

use App\Enums\EntrySheetType;
use Illuminate\Http\Resources\Json\JsonResource;

class DisasterEntrySheetResource extends JsonResource
{
    public static $wrap = null;

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'disaster_id' => $this->disaster_id,
            'type' => $this->type,
            'name' => $this->name,
            'name_kana' => $this->name_kana,
            'web' => $this->type == EntrySheetType::WEB ? new DisasterEntrySheetWebResource($this->web) : null,
            'paper' => $this->type == EntrySheetType::PAPER ? new DisasterEntrySheetPaperResource($this->paper) : null,
            'is_entered' => $this->entry != null,
            'created_at' => optional($this->created_at)->format('Y-m-d\TH:i:s'),
        ];
    }
}
