<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HomeDisasterResource extends JsonResource
{
    public static $wrap = null;

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'number_of_shelters' => count($this->disasterShelters),
            'number_of_entries' => count($this->entries),
            'start_at' => $this->start_at->format('Y-m-d\TH:i:s'),
            'end_at' => optional($this->end_at)->format('Y-m-d\TH:i:s'),
            'disaster_shelters' => HomeDisasterShelterResource::collection($this->disasterShelters),
        ];
    }
}
