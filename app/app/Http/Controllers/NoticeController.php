<?php

namespace App\Http\Controllers;

use App\Http\Requests\NoticeStoreRequest;
use App\Http\Resources\NoticeCollection;
use App\Http\Resources\NoticeResource;
use App\Services\NoticeService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NoticeController extends Controller
{
    private $notice_service;

    public function __construct(NoticeService $notice_service)
    {
        $this->middleware('auth');
        $this->notice_service = $notice_service;
    }

    /**
     * 避難所 - 一覧
     */
    public function index()
    {
        return new NoticeCollection([
            'notices' => $this->notice_service->find(),
        ]);
    }

    /**
     * 避難所 - 詳細
     */
    public function show($id)
    {
        $notice = $this->notice_service->show($id);
        if (empty($notice)) {
            throw new NotFoundHttpException('not found');
        }
        return new NoticeResource($notice);
    }

    /**
     * 避難所 - 新規作成
     */
    public function store(NoticeStoreRequest $request)
    {
        return new NoticeResource($this->notice_service->add($request->fillable()));
    }

    /**
     * 避難所 - 更新
     */
    public function update(NoticeStoreRequest $request, $id)
    {
        $notice = $this->notice_service->update($request->fillable(), $id);
        if (empty($notice)) {
            throw new NotFoundHttpException('not found');
        }
        return new NoticeResource($notice);
    }

    /**
     * 避難所 - 削除
     */
    public function destroy($id)
    {
        $notice = $this->notice_service->delete($id);
        if (empty($notice)) {
            throw new NotFoundHttpException('not found');
        }
    }
}
