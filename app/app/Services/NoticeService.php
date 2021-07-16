<?php

namespace App\Services;

use App\Models\Notice;

class NoticeService
{
    /**
     * お知らせ一覧
     */
    public function find()
    {
        $query = Notice::select('*');
        return $query->get();
    }

    /**
     * お知らせ詳細
     */
    public function show($id)
    {
        $query = Notice::select('*');
        $query->where('id', $id);
        return $query->first();
    }

    /**
     * お知らせ登録
     */
    public function add($request)
    {
        $notice = new Notice($request);
        $notice->save();
        return $notice;
    }

    /**
     * お知らせ更新
     */
    public function update($request, $id)
    {
        $notice = $this->show($id);
        if (empty($notice)) {
            return;
        }
        $notice->fill($request);
        $notice->save();
        return $notice;
    }

    /**
     * お知らせ削除
     */
    public function delete($id)
    {
        $notice = $this->show($id);
        if (empty($notice)) {
            return;
        }
        $notice->deleted_by = auth()->user()->id;
        return $notice->delete();
    }
}
