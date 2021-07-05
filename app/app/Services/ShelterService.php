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
     * 避難所登録
     */
    public function add($request)
    {
        $shelter = new Shelter($request->fillable());
        $shelter->save();
        return $shelter;
    }
}
