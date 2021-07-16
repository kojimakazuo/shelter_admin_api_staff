<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class StaffUserCollection extends ResourceCollection
{
    public static $wrap = null;

    public function toArray($request)
    {
        return [
            'staff_users' => StaffUserResource::collection($this->collection['staff_users']),
        ];
    }
}
