<?php

namespace App\Http\Controllers;

use App\Http\Requests\FacilityStoreRequest;
use App\Http\Requests\FacilityUpdateImageRequest;
use App\Http\Requests\FacilityUpdateRequest;
use App\Http\Resources\FacilityCollection;
use App\Http\Resources\FacilityResource;
use App\Services\FacilityService;

class FacilityController extends Controller
{
    private $facility_service;

    public function __construct(FacilityService $facility_service)
    {
        $this->middleware('auth');
        $this->facility_service = $facility_service;
    }

    /**
     * 避難所設備 - 一覧
     */
    public function index()
    {
        return new FacilityCollection([
            'facilities' => $this->facility_service->find(),
        ]);
    }

    /**
     * 避難所設備 - 新規作成
     */
    public function store(FacilityStoreRequest $request)
    {
        $data = $request->validated();
        $shelter_facility = $this->facility_service->add($data);
        return new FacilityResource($shelter_facility);
    }

    /**
     * 避難所設備 - 更新
     */
    public function update(int $id, FacilityUpdateRequest $request)
    {
        $shelter_facility = $this->facility_service->update($id, $request->validated());
        if (empty($shelter_facility)) {
            return response()->notfound();
        }
        return new FacilityResource($shelter_facility);
    }

    /**
     * 避難所設備 - 削除
     */
    public function destroy($id)
    {
        $shelter_facility = $this->facility_service->delete($id);
        if (empty($shelter_facility)) {
            return response()->notfound();
        }
    }

    /**
     * 避難所画像 - 更新
     */
    public function updateImage(int $id, FacilityUpdateImageRequest $request)
    {
        $data = $request->validated();
        $facility = $this->facility_service->updateImage($id, $data['image']);
        return new FacilityResource($facility);
    }
}
