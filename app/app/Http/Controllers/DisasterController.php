<?php

namespace App\Http\Controllers;

use App\Http\Requests\DisasterStoreRequest;
use App\Http\Requests\DisasterUpdateRequest;
use App\Http\Resources\DisasterCollection;
use App\Http\Resources\DisasterResource;
use App\Services\DisasterService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DisasterController extends Controller
{
    private $disaster_service;

    public function __construct(DisasterService $disaster_service)
    {
        $this->middleware('auth');
        $this->disaster_service = $disaster_service;
    }

    /**
     * 災害 - 一覧
     */
    public function index()
    {
        return new DisasterCollection([
            'disasters' => $this->disaster_service->find(),
        ]);
    }

    /**
     * 災害 - 現在発生中の災害
     */
    public function current()
    {
        $disaster = $this->disaster_service->current();
        if (empty($disaster)) {
            throw new NotFoundHttpException('not found');
        }
        return new DisasterResource($disaster);
    }

    /**
     * 災害 - 詳細
     */
    public function show($id)
    {
        $disaster = $this->disaster_service->show($id);
        if (empty($disaster)) {
            throw new NotFoundHttpException('not found');
        }
        return new DisasterResource($disaster);
    }

    /**
     * 災害 - 新規作成
     */
    public function store(DisasterStoreRequest $request)
    {
        return new DisasterResource($this->disaster_service->add($request->fillable()));
    }

    /**
     * 災害 - 更新
     */
    public function update(DisasterUpdateRequest $request, $id)
    {
        $disaster = $this->disaster_service->update($request->fillable(), $id);
        if (empty($disaster)) {
            throw new NotFoundHttpException('not found');
        }
        return new DisasterResource($disaster);
    }

    /**
     * 災害 - 削除
     */
    public function destroy($id)
    {
        $disaster = $this->disaster_service->delete($id);
        if (empty($disaster)) {
            throw new NotFoundHttpException('not found');
        }
    }
}
