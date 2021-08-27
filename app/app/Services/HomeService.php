<?php

namespace App\Services;

class HomeService
{
    private $municipality_service;
    private $disaster_service;

    public function __construct(MunicipalityService $municipality_service, DisasterService $disaster_service)
    {
        $this->municipality_service = $municipality_service;
        $this->disaster_service = $disaster_service;
    }

    /**
     * HOME
     */
    public function find()
    {
        return [
            'municipality' => $this->municipality_service->first(),
            'disaster' => $this->disaster_service->current(),
        ];
    }
}
