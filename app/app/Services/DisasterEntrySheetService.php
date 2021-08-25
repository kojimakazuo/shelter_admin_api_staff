<?php

namespace App\Services;

use App\Enums\EntrySheetType;
use App\Models\EntrySheet;
use App\Models\EntrySheetWebCompanion;
use Illuminate\Support\Facades\DB;

class DisasterEntrySheetService
{
    /**
     * 一覧
     */
    public function find($disaster_id, $entry_sheet_id, $created_at_from, $name_kana)
    {
        $query = EntrySheet::select('*');
        $query->doesntHave('entry');
        $query->where('disaster_id', $disaster_id);
        $query->where('type', EntrySheetType::WEB);
        if (!empty($entry_sheet_id)) {
            $query->where('id', $entry_sheet_id);
        }
        if (!empty($created_at_from)) {
            $query->where('created_at', '>=' , $created_at_from);
        }
        if (!empty($name_kana)) {
            $query->where('name_kana', 'like', "$name_kana%");
        }
        $query->orderBy('id', 'asc');
        return $query->paginate(50);
    }

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
     * WEB更新
     */
    public function updateWeb($id, $request)
    {
        $entry_sheet = DB::transaction(function () use ($id, $request) {
            // Save EntrySheet
            $entry_sheet = EntrySheet::find($id);
            $entry_sheet->fill($request)->save();
            // Save EntrySheetWeb
            $entry_sheet->web->fill($request)->save();
            // Save EntrySheetWebCompanions
            $new_entry_sheet_web_companions = $request['companions'];
            foreach ($entry_sheet->web->companions as &$companion) {
                $index = array_search($companion->id, array_column($new_entry_sheet_web_companions, 'id'));
                if ($index !== FALSE) {
                    // 指定されたidが存在する場合は更新
                    $companion->fill($new_entry_sheet_web_companions[$index])->save();
                    continue;
                } else {
                    // 削除
                    $companion->delete();
                }
            }
            unset($companion);
            $add_entry_sheet_web_companions = array_map(function($e) use ($entry_sheet) {
                $companion = new EntrySheetWebCompanion();
                $companion->fill($e);
                $companion->entry_sheet_web_id = $entry_sheet->web->id;
                return $companion;
            }, array_filter($new_entry_sheet_web_companions, function($e) {
                return !array_key_exists('id', $e);
            }));
            $entry_sheet->web->companions()->saveMany($add_entry_sheet_web_companions);
            // Save EntrySheetWebEnquete
            $entry_sheet->web->enquete->update(['data' => $request['enquetes']]);
            return $entry_sheet;
        });
        return $this->show($entry_sheet->id);
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
