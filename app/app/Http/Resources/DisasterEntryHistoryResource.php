<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DisasterEntryHistoryResource extends JsonResource
{
    public static $wrap = null;

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'occurred_at' => $this->occurred_at->format('Y-m-d\TH:i:s'),
        ];
    }
}
