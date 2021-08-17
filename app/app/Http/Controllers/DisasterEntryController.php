<?php

namespace App\Http\Controllers;

use App\Http\Requests\DisasterEntryWebRequest;
use App\Http\Resources\DisasterEntryResource;
use App\Services\DisasterEntryService;
use App\Services\DisasterEntrySheetService;
use App\Services\DisasterService;

class DisasterEntryController extends Controller
{
    private $disaster_service;
    private $disaster_entry_service;
    private $disaster_entry_sheet_service;

    public function __construct(DisasterService $disaster_service, DisasterEntryService $disaster_entry_service, DisasterEntrySheetService $disaster_entry_sheet_service)
    {
        $this->middleware('auth');
        $this->disaster_service = $disaster_service;
        $this->disaster_entry_service = $disaster_entry_service;
        $this->disaster_entry_sheet_service = $disaster_entry_sheet_service;
    }

    /**
     * 災害 - 受付 - WEB受付
     */
    public function web(DisasterEntryWebRequest $request)
    {
        $entry_sheet_id = $request->fillable()['entry_sheet_id'];
        // 受付済みチェック
        if (!empty($this->disaster_entry_service->findByEntrySheetId($entry_sheet_id))) {
            return response()->badrequest(null, 'この受付シートはすでに受付済です');
        }
        $entry_sheet = $this->disaster_entry_sheet_service->web($entry_sheet_id);
        // エントリーシート存在チェック
        if (empty($entry_sheet)) {
            return response()->notfound();
        }
        // 災害開催チェック
        if (!$this->disaster_service->isOccurring($entry_sheet->disaster_id)) {
            return response()->badrequest(null, 'この受付シートは現在発生中の災害で作成されたものではないため無効です');
        }
        $entry = $this->disaster_entry_service->entry($request->fillable());
        return new DisasterEntryResource($entry);
    }
}