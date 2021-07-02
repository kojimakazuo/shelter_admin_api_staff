<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShelterStoreRequest;
use App\Http\Resources\ShelterResource;
use App\Models\Shelter;

class ShelterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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
