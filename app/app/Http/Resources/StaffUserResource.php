<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StaffUserResource extends JsonResource
{
    public static $wrap = null;

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'login_id' => $this->login_id,
            'name' => $this->name,
            'name_kana' => $this->name_kana,
            'phone_number' => $this->phone_number,
            'role' => $this->role,
        ];
    }
}
