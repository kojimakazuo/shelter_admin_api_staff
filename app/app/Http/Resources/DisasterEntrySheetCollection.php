<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DisasterEntrySheetCollection extends ResourceCollection
{
    public static $wrap = null;

    public function toArray($request)
    {
        return [
            'entry_sheets' => DisasterEntrySheetResource::collection($this->collection['entry_sheets']),
        ];
    }
}
