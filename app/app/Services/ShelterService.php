<?php

namespace App\Services;

use App\Models\Shelter;

class ShelterService
{
    /**
     * 避難所一覧
     */
    public function find()
    {
        $query = Shelter::select('*');
        $query->whereNull('deleted_at');
        return $query->get();
    }

    /**
     * 避難所詳細
     */
    public function show($id)
    {
        $query = Shelter::select('*');
        $query->where('id', $id);
        $query->whereNull('deleted_at');
        return $query->first();
    }

    /**
     * 避難所登録
     */
    public function add($request)
    {
        $shelter = new Shelter($request);
        $shelter->save();
        return $shelter;
    }

    /**
     * 避難所更新
     */
    public function update($request, $id)
    {
        $shelter = $this->show($id);
        if (empty($shelter)) {
            return;
        }
        $shelter->fill($request);
        $shelter->save();
        return $shelter;
    }
}
