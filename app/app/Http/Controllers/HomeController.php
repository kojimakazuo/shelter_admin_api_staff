<?php

namespace App\Http\Controllers;

use App\Http\Resources\HomeCollection;
use App\Services\HomeService;

class HomeController extends Controller
{
    private $home_service;

    public function __construct(HomeService $home_service)
    {
        $this->middleware('auth');
        $this->home_service = $home_service;
    }

    /**
     * HOME
     */
    public function index()
    {
        return new HomeCollection($this->home_service->find());
    }
}
