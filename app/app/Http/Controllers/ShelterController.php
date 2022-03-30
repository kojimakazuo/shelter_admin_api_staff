<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShelterStoreImageRequest;
use App\Http\Requests\ShelterStoreRequest;
use App\Http\Requests\ShelterUpdateRequest;
use App\Http\Resources\ShelterCollection;
use App\Http\Resources\ShelterImageResource;
use App\Http\Resources\ShelterResource;
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
     * 避難所 - 詳細
     */
    public function show(int $id)
    {
        $shelter = $this->shelter_service->show($id);
        if (empty($shelter)) {
            return response()->notfound();
        }
        return new ShelterResource($shelter);
    }

    /**
     * 避難所 - 新規作成
     */
    public function store(ShelterStoreRequest $request)
    {
        $data = $request->validated();
        $shelter = $this->shelter_service->add($data);
        $this->shelter_service->addImages($shelter->id, $data['images']);
        return new ShelterResource($shelter);
    }

    /**
     * 避難所 - 更新
     */
    public function update(int $id, ShelterUpdateRequest $request)
    {
        $shelter = $this->shelter_service->update($id, $request->validated());
        if (empty($shelter)) {
            return response()->notfound();
        }
        return new ShelterResource($shelter);
    }

    /**
     * 避難所 - 削除
     */
    public function destroy(int $id)
    {
        $shelter = $this->shelter_service->delete($id);
        if (empty($shelter)) {
            return response()->notfound();
        }
    }

    /**
     * 避難所画像 - 登録
     */
    public function storeShelterImage(int $id, ShelterStoreImageRequest $request)
    {
        $data = $request->validated();
        $this->shelter_service->addImage($id, $data['image']);
        $shelter = $this->shelter_service->show($id);
        return ShelterImageResource::collection($shelter->shelterImages);
    }

    /**
     * 避難所画像 - 削除
     */
    public function destroyShelterImage(int $id, int $image_id)
    {
        $this->shelter_service->deleteImage($id, $image_id);
        $shelter = $this->shelter_service->show($id);
        return ShelterImageResource::collection($shelter->shelterImages);
    }
}
