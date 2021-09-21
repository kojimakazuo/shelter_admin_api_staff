<?php

namespace App\Http\Controllers;

use App\Http\Requests\DisasterEntrySheetPaperRequest;
use App\Http\Requests\DisasterEntrySheetSearchRequest;
use App\Http\Requests\DisasterEntrySheetWebRequest;
use App\Http\Resources\DisasterEntrySheetCollection;
use App\Http\Resources\DisasterEntrySheetResource;
use App\Services\DisasterEntryService;
use App\Services\DisasterEntrySheetService;
use App\Services\DisasterService;

class DisasterEntrySheetController extends Controller
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
     * 災害 - 受付シート - 詳細(QRコードデータ(W00形式))
     */
    public function qrcode($value)
    {
        $disaster = $this->disaster_service->current();
        if (empty($disaster)) {
            return response()->notfound();
        }
        preg_match('/^([WP])([0-9]+$)/u', $value, $matches);
        if (count($matches) < 3) {
            // 形式エラー
            return response()->notfound();
        }
        $entry_type = $matches[1];
        switch($entry_type) {
            case 'W':
                $entry_sheet_id = $matches[2];
                $entry_sheet = $this->disaster_entry_sheet_service->show($entry_sheet_id);
                if (empty($entry_sheet)) {
                    return response()->notfound();
                }
                return new DisasterEntrySheetResource($entry_sheet);
            case 'P':
                $sheet_number = $matches[2];
                $entry_sheet = $this->disaster_entry_sheet_service->paperFromSheetNumber($disaster->id, $sheet_number);
                if (empty($entry_sheet)) {
                    return response()->notfound();
                }
                return new DisasterEntrySheetResource($entry_sheet);
        }
    }

    /**
     * 災害 - 受付シート - WEB詳細
     */
    public function web($id)
    {
        $entry_sheet = $this->disaster_entry_sheet_service->web($id);
        if (empty($entry_sheet)) {
            return response()->notfound();
        }
        return new DisasterEntrySheetResource($entry_sheet);
    }

    /**
     * 災害 - 受付シート - WEB更新
     */
    public function updateWeb($id, DisasterEntrySheetWebRequest $request)
    {
        if (empty($this->disaster_entry_sheet_service->web($id))) {
            return response()->notfound();
        }
        $entry_sheet = $this->disaster_entry_sheet_service->updateWeb($id, $request->fillable());
        return new DisasterEntrySheetResource($entry_sheet);
    }

    /**
     * 災害 - 受付シート - 紙詳細
     */
    public function paper($id)
    {
        $entry_sheet = $this->disaster_entry_sheet_service->paper($id);
        if (empty($entry_sheet)) {
            return response()->notfound();
        }
        return new DisasterEntrySheetResource($entry_sheet);
    }

    /**
     * 災害 - 受付シート - 紙更新
     */
    public function updatePaper($id, DisasterEntrySheetPaperRequest $request)
    {
        // 管理番号使用済みチェック
        $entry_sheet = $this->paper($id);
        $sheet_number = $request->fillable()['sheet_number'];
        if (!empty($this->disaster_entry_service->findBySheetNumber($entry_sheet->disaster_id, $sheet_number, $entry_sheet->id))) {
            return response()->badrequest(null, 'この管理番号はすでに使用されています');
        }
        $entry_sheet = $this->disaster_entry_sheet_service->updatePaper($id, $request->fillable());
        return new DisasterEntrySheetResource($entry_sheet);
    }
}
