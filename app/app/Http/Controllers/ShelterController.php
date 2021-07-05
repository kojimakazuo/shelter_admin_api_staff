<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShelterStoreRequest;
use App\Http\Resources\ShelterCollection;
use App\Http\Resources\ShelterResource;
use App\Models\Shelter;
use App\Services\ShelterService;

class ShelterController extends Controller
{
    private $shelter_service;

    public function __construct(ShelterService $shelter_service)
    {
        $this->middleware('auth');
        $this->shelter_service = $shelter_service;
    }

    /**
     * 避難所 - 一覧
     */
    public function index()
    {
        return new ShelterCollection([
            'shelters' => $this->shelter_service->find(),
        ]);
    }

    /**
     * 災害 - 新規作成
     */
    public function store(ShelterStoreRequest $request)
    {
        $shelter = new Shelter($request->fillable());
        $shelter->save();
        return new ShelterResource($shelter);
    }
}
