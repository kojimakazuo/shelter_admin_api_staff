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
}
