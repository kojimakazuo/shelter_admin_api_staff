<?php

namespace App\Services;

use App\Enums\EntrySheetType;
use App\Models\EntrySheet;
use App\Models\EntrySheetWebCompanion;

class DisasterEntrySheetService
{
    /**
     * 詳細
     */
    public function show($id)
    {
        $query = EntrySheet::select('*');
        $query->where('id', $id);
        return $query->first();
    }

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

    /**
     * 体温更新
     */
    public function updateTemperatures($id, $temperature, $companions)
    {
        $entry_sheet = $this->show($id);
        switch($entry_sheet->type) {
            case EntrySheetType::WEB:
                $entry_sheet_web = $entry_sheet->web;
                $entry_sheet_web->temperature = $temperature;
                $entry_sheet_web->save();

                foreach ($entry_sheet_web->companions as &$companion) {
                    $index = array_search($companion->id, array_column($companions, 'id'));
                    if ($index !== FALSE) {
                        // idがある場合は更新
                        $companion->temperature = $companions[$index]['temperature'];
                        $companion->save();
                    }
                }
                unset($companion);
                return $entry_sheet;
            case EntrySheetType::PAPER:
                // TODO: 未実装
                return $entry_sheet;
        }
    }
}