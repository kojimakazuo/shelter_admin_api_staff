<?php

namespace App\Services;

use App\Enums\EntryHistoryType;
use App\Enums\EntrySheetType;
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
     * 災害受付一覧
     */
    public function find($disaster_id, $disaster_shelter_id, $entered_at_from, $name_kana, $per_page = 10)
    {
        $query = Entry::select('entries.*');
        $query->join('entry_sheets','entry_sheets.id','=','entries.entry_sheet_id');
        $query->where('disaster_id', $disaster_id);
        if (!empty($disaster_shelter_id)) {
            $query->where('disaster_shelter_id', $disaster_shelter_id);
        }
        if (!empty($entered_at_from)) {
            $query->where('entered_at', '>=' , $entered_at_from);
        }
        if (!empty($name_kana)) {
            $query->where('name_kana', 'like', "$name_kana%");
        }
        $query->orderBy('entries.id', 'asc');
        return $query->paginate($per_page);
    }

    /**
     * 災害受付(WEB)
     */
    public function entryForWeb($request)
    {
        $entry = DB::transaction(function () use ($request) {
            $entered_at = now(); // 入場日時
            // Save Entry
            $entry = new Entry($request);
            $entry->entered_at = $entered_at;
            $entry->save();
            // Save EntryHistory
            $entry_history = new EntryHistory($request);
            $entry_history->type = EntryHistoryType::ENTRY;
            $entry_history->occurred_at = $entered_at;
            $entry->histories()->save($entry_history);
            $this->disaster_entry_sheet_service->updateTemperatures($request['entry_sheet_id'], $request['temperature'], $request['companions']);
            return $entry;
        });
        return $entry;
    }

    /**
     * 災害受付(紙)
     */
    public function entryForPaper($disaster_id, $request)
    {
        $entry = DB::transaction(function () use ($disaster_id, $request) {
            $entered_at = now(); // 入場日時
            // Save EntrySheet
            $entry_sheet = $this->disaster_entry_sheet_service->addPaper($disaster_id, $request);
            // Save Entry
            $entry = new Entry($request);
            $entry->entry_sheet_id = $entry_sheet->id;
            $entry->entered_at = $entered_at;
            $entry->save();
            // Save EntryHistory
            $entry_history = new EntryHistory($request);
            $entry_history->type = EntryHistoryType::ENTRY;
            $entry_history->occurred_at = $entered_at;
            $entry->histories()->save($entry_history);
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

    /**
     * 災害受付詳細(By SheetNumber)
     */
    public function findBySheetNumber($disaster_id, $sheet_number, $exclude_entry_sheet_id = null)
    {
        $query = Entry::select('entries.*');
        $query->join('entry_sheets', 'entry_sheets.id', '=', 'entries.entry_sheet_id');
        $query->join('entry_sheet_papers', 'entry_sheet_papers.entry_sheet_id', '=', 'entry_sheets.id');
        $query->where('type', EntrySheetType::PAPER);
        $query->where('disaster_id', $disaster_id);
        $query->where('sheet_number', $sheet_number);
        if ($exclude_entry_sheet_id != null) {
            $query->where('entry_sheets.id', '<>', $exclude_entry_sheet_id);
        }
        return $query->first();
    }

    /**
     * 災害受付 - 一時退室
     */
    public function out($id)
    {
        $entry = $this->show($id);
        $entry_history = new EntryHistory();
        $entry_history->type = EntryHistoryType::OUT;
        $entry_history->occurred_at = now();
        return $entry->histories()->save($entry_history);
    }

    /**
     * 災害受付 - 再入場
     */
    public function in($id)
    {
        $entry = $this->show($id);
        $entry_history = new EntryHistory();
        $entry_history->type = EntryHistoryType::IN;
        $entry_history->occurred_at = now();
        return $entry->histories()->save($entry_history);
    }

    /**
     * 災害受付 - 退場
     */
    public function exit($id)
    {
        $entry = DB::transaction(function () use ($id) {
            $exited_at = now(); // 退場日時
            // Save Entry
            $entry = $this->show($id);
            $entry->exited_at = $exited_at;
            $entry->save();
            // Save EntryHistory
            $entry_history = new EntryHistory();
            $entry_history->type = EntryHistoryType::EXIT;
            $entry_history->occurred_at = $exited_at;
            $entry->histories()->save($entry_history);
            return $entry;
        });
        return $entry;
    }
}
