<?php

namespace App\Http\Controllers;

use App\Http\Requests\DisasterEntrySheetSearchRequest;
use App\Http\Resources\DisasterEntryResource;
use App\Http\Resources\DisasterEntrySheetCollection;
use App\Http\Resources\DisasterEntrySheetWebResource;
use App\Services\DisasterEntryService;
use App\Services\DisasterEntrySheetService;

class DisasterEntrySheetController extends Controller
{
    private $disaster_entry_service;
    private $disaster_entry_sheet_service;

    public function __construct(DisasterEntryService $disaster_entry_service, DisasterEntrySheetService $disaster_entry_sheet_service)
    {
        $this->middleware('auth');
        $this->disaster_entry_service = $disaster_entry_service;
        $this->disaster_entry_sheet_service = $disaster_entry_sheet_service;
    }

    /**
     * 災害 - 受付シート - 一覧
     */
    public function index($id, DisasterEntrySheetSearchRequest $request)
    {
        $params = $request->formattedQueryParams();
        return new DisasterEntrySheetCollection([
            'entry_sheets' => $this->disaster_entry_sheet_service->find($id, $params['entry_sheet_id'] ?? NULL, $params['created_at_from'] ?? NULL, $params['name_kana'] ?? NULL),
        ]);
    }

    /**
     * 災害 - 受付シート - WEB詳細
     */
    public function web($id)
    {
        $entry = $this->disaster_entry_service->findByEntrySheetId($id);
        if (!empty($entry)) {
            return response()->badrequest(null, 'このシートはすでに受付済です');
        }
        $entry_sheet = $this->disaster_entry_sheet_service->web($id);
        if (empty($entry_sheet)) {
            return response()->notfound();
        }
        return new DisasterEntrySheetWebResource($entry_sheet);
    }

    /**
     * 災害 - 受付シート - 受付詳細
     */
    public function entry($id)
    {
        $entry_sheet = $this->disaster_entry_sheet_service->show($id);
        if (empty($entry_sheet)) {
            return response()->notfound();
        }
        if (empty($entry_sheet->entry)) {
            return response()->badrequest(null, 'このシートは受付されていません');
        }
        return new DisasterEntryResource($entry_sheet->entry);
    }
}
