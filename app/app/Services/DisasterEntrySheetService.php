<?php

namespace App\Services;

use App\Enums\EntrySheetType;
use App\Models\EntrySheet;

class DisasterEntrySheetService
{
    /**
     * WEB詳細
     */
    public function web($id)
    {
        $query = EntrySheet::select('*');
        $query->where('id', $id);
        $query->where('type', EntrySheetType::WEB);
        return $query->first();
    }
}
