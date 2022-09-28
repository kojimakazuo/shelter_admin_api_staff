<?php

namespace App\Http\Controllers;

use App\Http\Requests\DisasterShelterStaffsStoreRequest;
use App\Http\Requests\DisasterShelterStaffsUpdateRequest;
use App\Http\Resources\DisasterShelterStaffsCollection;
use App\Http\Resources\DisasterShelterStaffsResource;
use App\Services\DisasterShelterStaffsService;

class DisasterShelterStaffsController extends Controller
{
    private $disasterShelterStaffs_service;

    public function __construct(DisasterShelterStaffsService $disasterShelterStaffs_service)
    {
        $this->middleware('auth');
        $this->disasterShelterStaffs_service = $disasterShelterStaffs_service;
    }

   /**
     * 開設避難所スタッフ - TEST
     * 
     */
    public function test()
    {
        return new DisasterShelterStaffsCollection([
            'disaster_shelter_staffs' => $this->disasterShelterStaffs_service->test(),
        ]);
    }

    /**
     * 開設避難所スタッフ - 一覧
     */
    public function index($shelter_id)
    {
        return new DisasterShelterStaffsCollection([
            'disaster_shelter_staffs' => $this->disasterShelterStaffs_service->find($shelter_id),
        ]);
    }

    /**
     * 開設避難所スタッフ - 更新
     */
    public function update(DisasterShelterStaffsUpdateRequest $request, $staff_user_id)
    {
        return new DisasterShelterStaffsResource($this->disasterShelterStaffs_service->update($request->fillable(), $staff_user_id));
    }
}
