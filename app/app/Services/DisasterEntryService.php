<?php

namespace App\Services;

use App\Enums\EntryHistoryType;
use App\Models\Entry;
use App\Models\EntryHistory;
use Illuminate\Support\Facades\DB;

class DisasterEntryService
{
    private $disaster_entry_sheet_service;

    public function __construct(DisasterEntrySheetService $disaster_entry_sheet_service)
    {
        $this->disaster_entry_sheet_service = $disaster_entry_sheet_service;
    }

    /**
     * 災害受付
     */
    public function entry($request)
    {
        $entry = DB::transaction(function () use ($request) {
            $enterd_at = now(); // 入場日時
            // Save Entry
            $entry = new Entry($request);
            $entry->enterd_at = $enterd_at;
            $entry->save();
            // Save EntryHistory
            $entry_history = new EntryHistory($request);
            $entry_history->type = EntryHistoryType::ENTRY;
            $entry_history->occurred_at = $enterd_at;
            $entry->EntryHistories()->save($entry_history);
            $this->disaster_entry_sheet_service->updateTemperatures($request['entry_sheet_id'], $request['temperature'], $request['companions']);
            return $entry;
        });
        return $entry;
    }

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
