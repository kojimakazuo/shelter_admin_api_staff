<?php

namespace App\Services;

use App\Models\MunicipalitySetting;

class MunicipalityService
{
    /**
     * 自治体設定
     */
    public function first()
    {
        return MunicipalitySetting::select('*')->first();
    }
}
