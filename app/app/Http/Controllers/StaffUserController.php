<?php

namespace App\Http\Controllers;

use App\Http\Requests\StaffUserStoreRequest;
use App\Http\Resources\StaffUserCollection;
use App\Http\Resources\StaffUserResource;
use App\Services\StaffUserService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class StaffUserController extends Controller
{
    private $staff_user_service;

    public function __construct(StaffUserService $staff_user_service)
    {
        $this->middleware(['auth', 'can:admin']);
        $this->staff_user_service = $staff_user_service;
    }

    /**
     * スタッフ - 一覧
     */
    public function index()
    {
        return new StaffUserCollection([
            'staff_users' => $this->staff_user_service->find(),
        ]);
    }

    /**
     * スタッフ - 詳細
     */
    public function show($id)
    {
        $staff_user = $this->staff_user_service->show($id);
        if (empty($staff_user)) {
            throw new NotFoundHttpException('not found');
        }
        return new StaffUserResource($staff_user);
    }

    /**
     * スタッフ - 新規作成
     */
    public function store(StaffUserStoreRequest $request)
    {
        return new StaffUserResource($this->staff_user_service->add($request->fillable()));
    }

    /**
     * スタッフ - 更新
     */
    public function update(StaffUserStoreRequest $request, $id)
    {
        $staff_user = $this->staff_user_service->update($request->fillable(), $id);
        if (empty($staff_user)) {
            throw new NotFoundHttpException('not found');
        }
        return new StaffUserResource($staff_user);
    }

    /**
     * スタッフ - 削除
     */
    public function destroy($id)
    {
        $staff_user = $this->staff_user_service->delete($id);
        if (empty($staff_user)) {
            throw new NotFoundHttpException('not found');
        }
    }
}
