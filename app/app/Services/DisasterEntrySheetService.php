<?php

namespace App\Services;

use App\Enums\EntrySheetType;
use App\Models\EntrySheet;
use App\Models\EntrySheetPaper;
use App\Models\EntrySheetPaperCompanion;
use App\Models\EntrySheetWebCompanion;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DisasterEntrySheetService
{
    /**
     * 一覧
     */
    public function find($disaster_id, $entry_sheet_id, $created_at_from, $name_kana, $per_page = 10)
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
        return $query->paginate($per_page);
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
     * PAPER詳細
     */
    public function paper($id)
    {
        $query = EntrySheet::select('*');
        $query->where('id', $id);
        $query->where('type', EntrySheetType::PAPER);
        return $query->first();
    }

    /**
     * PAPER詳細(管理番号から)
     */
    public function paperFromSheetNumber($disaster_id, $sheet_number)
    {
        $query = EntrySheet::select('entry_sheets.*');
        $query->join('entry_sheet_papers', 'entry_sheet_papers.entry_sheet_id', '=', 'entry_sheets.id');
        $query->where('disaster_id', $disaster_id);
        $query->where('sheet_number', $sheet_number);
        return $query->first();
    }

    /**
     * WEB更新
     */
    public function updateWeb($id, $request)
    {
        $entry_sheet = DB::transaction(function () use ($id, $request) {
            $new_entry_sheet_web_companions = $request['companions'];
            // Save EntrySheet
            $entry_sheet = EntrySheet::find($id);
            $entry_sheet->number_of_evacuees = count($new_entry_sheet_web_companions) + 1;
            $entry_sheet->fill($request)->save();
            // Save EntrySheetWeb
            $entry_sheet->web->fill($request)->save();
            // Save EntrySheetWebCompanions
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
     * 紙登録
     */
    public function addPaper($disaster_id, $request)
    {
        $request['disaster_id'] = $disaster_id;
        $request['type'] = EntrySheetType::PAPER;
        $entry_sheet = DB::transaction(function () use ($request) {
            $entry_sheet_paper_companions = array_map(function($companion) {
                return new EntrySheetPaperCompanion($companion);
            }, $request['companions']);
            // Save EntrySheet
            $entry_sheet = new EntrySheet($request);
            $entry_sheet->number_of_evacuees = count($entry_sheet_paper_companions) + 1;
            $entry_sheet->save();
            // // Save EntrySheetPaper
            $entry_sheet_paper = new EntrySheetPaper($request);
            $entry_sheet->paper()->save($entry_sheet_paper);
            // Save EntrySheetPaperCompanions
            $entry_sheet_paper->companions()->saveMany($entry_sheet_paper_companions);
            $this->updatePaperFrontImage($entry_sheet->id, $request['front_image']);
            if (isset($request['back_image'])) {
                $this->updatePaperBackImage($entry_sheet->id, $request['back_image']);
            }
            return $entry_sheet;
        });
        return $entry_sheet;
    }

    /**
     * 紙更新
     */
    public function updatePaper($id, $request)
    {
        $entry_sheet = DB::transaction(function () use ($id, $request) {
            $new_entry_sheet_paper_companions = $request['companions'];
            // Save EntrySheet
            $entry_sheet = EntrySheet::find($id);
            $entry_sheet->number_of_evacuees = count($new_entry_sheet_paper_companions) + 1;
            $entry_sheet->fill($request)->save();
            // Save EntrySheetPaper
            $entry_sheet->paper->fill($request)->save();
            // Save EntrySheetPaperCompanions
            foreach ($entry_sheet->paper->companions as &$companion) {
                $index = array_search($companion->id, array_column($new_entry_sheet_paper_companions, 'id'));
                if ($index !== FALSE) {
                    // 指定されたidが存在する場合は更新
                    $companion->fill($new_entry_sheet_paper_companions[$index])->save();
                    continue;
                } else {
                    // 削除
                    $companion->delete();
                }
            }
            unset($companion);
            $add_entry_sheet_paper_companions = array_map(function($e) use ($entry_sheet) {
                $companion = new EntrySheetPaperCompanion();
                $companion->fill($e);
                $companion->entry_sheet_paper_id = $entry_sheet->paper->id;
                return $companion;
            }, array_filter($new_entry_sheet_paper_companions, function($e) {
                return !array_key_exists('id', $e);
            }));
            $entry_sheet->paper->companions()->saveMany($add_entry_sheet_paper_companions);
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

    public function updatePaperFrontImage($id, $base64_image)
    {
        $entry_sheet = $this->show($id);
        $paper_id = $entry_sheet->paper->id;

        preg_match('/data:image\/(\w+);base64,(.*)/u', $base64_image, $matches);
        $ext = $matches[1];
        $data = $matches[2];

        // AWS S3に格納
        $path = "entry_sheet_papers/$paper_id/front.$ext";
        Storage::disk('s3')->put($path, base64_decode($data), 'private');
        $s3_url = Storage::disk('s3')->url($path);
        $paper = $entry_sheet->paper;
        $paper->front_sheet_image_url = $s3_url;
        $paper->save();
    }

    public function updatePaperBackImage($id, $base64_image)
    {
        $entry_sheet = $this->show($id);
        $paper_id = $entry_sheet->paper->id;

        preg_match('/data:image\/(\w+);base64,(.*)/u', $base64_image, $matches);
        $ext = $matches[1];
        $data = $matches[2];

        // AWS S3に格納
        $path = "entry_sheet_papers/$paper_id/back.$ext";
        Storage::disk('s3')->put($path, base64_decode($data), 'private');
        $s3_url = Storage::disk('s3')->url($path);
        $paper = $entry_sheet->paper;
        $paper->back_sheet_image_url = $s3_url;
        $paper->save();
    }
}
