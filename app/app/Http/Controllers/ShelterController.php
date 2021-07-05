<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShelterStoreRequest;
use App\Http\Resources\ShelterCollection;
use App\Http\Resources\ShelterResource;
use App\Services\ShelterService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
     * 避難所詳細
     */
    public function show($id)
    {
        $shelter = $this->shelter_service->show($id);
        if (empty($shelter)) {
            throw new NotFoundHttpException('not found');
        }
        return new ShelterResource($shelter);
    }

    /**
     * 避難所 - 新規作成
     */
    public function store(ShelterStoreRequest $request)
    {
        return new ShelterResource($this->shelter_service->add($request->fillable()));
    }

    /**
     * 避難所 - 更新
     */
    public function update(ShelterStoreRequest $request, $id)
    {
        $shelter = $this->shelter_service->update($request->fillable(), $id);
        if (empty($shelter)) {
            throw new NotFoundHttpException('not found');
        }
        return new ShelterResource($shelter);
    }

    /**
     * 避難所 - 削除
     */
    public function destroy($id)
    {
        $shelter = $this->shelter_service->delete($id);
        if (empty($shelter)) {
            throw new NotFoundHttpException('not found');
        }
    }
}
