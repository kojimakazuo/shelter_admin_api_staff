<?php

namespace App\Services;

use App\Models\StaffUser;
use Illuminate\Support\Facades\Hash;

class StaffUserService
{
    /**
     * スタッフ一覧
     */
    public function find()
    {
        $query = StaffUser::select('*');
        return $query->get();
    }

    /**
     * スタッフ詳細
     */
    public function show($id)
    {
        $query = StaffUser::select('*');
        $query->where('id', $id);
        return $query->first();
    }

    /**
     * スタッフ登録
     */
    public function add($request)
    {
        $staffUser = new StaffUser($request);
        $staffUser->password = Hash::make($request['password']);
        $staffUser->save();
        return $staffUser;
    }

    /**
     * スタッフ更新
     */
    public function update($request, $id)
    {
        $staffUser = $this->show($id);
        if (empty($staffUser)) {
            return;
        }
        $staffUser->fill($request);
        $staffUser->password = Hash::make($request['password']);
        $staffUser->save();
        return $staffUser;
    }

    /**
     * スタッフ削除
     */
    public function delete($id)
    {
        $staffUser = $this->show($id);
        if (empty($staffUser)) {
            return;
        }
        $staffUser->deleted_by = auth()->user()->id;
        return $staffUser->delete();
    }
}
