<?php

namespace App\Services;

use App\Models\Entry;

class DisasterEntryService
{
    /**
     * 災害受付詳細
     */
    public function show($id)
    {
        $query = Entry::select('*');
        $query->where('id', $id);
        return $query->first();
    }

    /**
     * 災害受付詳細(By EntrySheetID)
     */
    public function findByEntrySheetId($id)
    {
        $query = Entry::select('*');
        $query->where('entry_sheet_id', $id);
        return $query->first();
    }
}
