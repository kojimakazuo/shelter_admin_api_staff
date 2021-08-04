<?php

namespace App\Services;

class HomeService
{
    private $disaster_service;

    public function __construct(DisasterService $disaster_service)
    {
        $this->disaster_service = $disaster_service;
    }

    /**
     * HOME
     */
    public function find()
    {
        return [
            'disaster' => $this->disaster_service->current(),
        ];
    }
}
