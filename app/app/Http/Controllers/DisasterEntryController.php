<?php

namespace App\Http\Controllers;

use App\Http\Requests\DisasterEntryPaperRequest;
use App\Http\Requests\DisasterEntrySearchRequest;
use App\Http\Requests\DisasterEntryWebRequest;
use App\Http\Resources\DisasterEntryCollection;
use App\Http\Resources\DisasterEntryResource;
use App\Services\DisasterEntryService;
use App\Services\DisasterEntrySheetService;
use App\Services\DisasterService;
use Illuminate\Support\Facades\DB;

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
     * 災害 - 受付一覧
     */
    public function index($id, DisasterEntrySearchRequest $request)
    {
        $params = $request->formattedQueryParams();
        return new DisasterEntryCollection([
            'entries' => $this->disaster_entry_service->find($id, $params['disaster_shelter_id'] ?? NULL, $params['entered_at_from'] ?? NULL, $params['name_kana'] ?? NULL),
        ]);
    }

    /**
     * 災害 - 受付 - 詳細
     */
    public function show($id)
    {
        $entry = $this->disaster_entry_service->show($id);
        if (empty($entry)) {
            return response()->notfound();
        }
        return new DisasterEntryResource($entry);
    }

    /**
     * 災害 - 受付 - 詳細(QRコードデータ(W00/P00形式))
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
                if (empty($entry_sheet->entry)) {
                    return response()->badrequest(null, 'このシートは受付されていません');
                }
                if (!empty($entry_sheet->entry->exited_at)) {
                    return response()->badrequest(null, 'このシートはすでに退場処理がされています');
                }
                return new DisasterEntryResource($entry_sheet->entry);
            case 'P':
                $sheet_number = $matches[2];
                // DB::enableQueryLog();
                $entry_sheet = $this->disaster_entry_sheet_service->paperFromSheetNumber($disaster->id, $sheet_number);
                // dd(DB::getQueryLog());
                if (empty($entry_sheet)) {
                    return response()->notfound();
                }
                if (empty($entry_sheet->entry)) {
                    return response()->badrequest(null, 'このシートは受付されていません');
                }
                if (!empty($entry_sheet->entry->exited_at)) {
                    return response()->badrequest(null, 'このシートはすでに退場処理がされています');
                }
                return new DisasterEntryResource($entry_sheet->entry);
        }
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
        $entry = $this->disaster_entry_service->entryForWeb($request->fillable());
        return new DisasterEntryResource($entry);
    }

    /**
     * 災害 - 受付 - 紙受付
     */
    public function paper(DisasterEntryPaperRequest $request)
    {
        $disaster = $this->disaster_service->current();
        if (empty($disaster)) {
            return response()->badrequest(null, '現在発生中の災害はありません');
        }
        // 管理番号使用済みチェック
        $sheet_number = $request->fillable()['sheet_number'];
        if (!empty($this->disaster_entry_service->findBySheetNumber($disaster->id, $sheet_number))) {
            return response()->badrequest(null, 'この管理番号はすでに使用されています');
        }
        $entry = $this->disaster_entry_service->entryForPaper($disaster->id, $request->fillable());
        return new DisasterEntryResource($entry);
    }

    /**
     * 災害 - 受付 - 一時退室
     */
    public function out($id)
    {
        $entry = $this->disaster_entry_service->show($id);
        if (empty($entry)) {
            return response()->notfound();
        }
        if (!empty($entry->exited_at)) {
            return response()->badrequest(null, 'この避難者はすでに退場済です');
        }
        $this->disaster_entry_service->out($id);
    }

    /**
     * 災害 - 受付 - 再入場
     */
    public function in($id)
    {
        $entry = $this->disaster_entry_service->show($id);
        if (empty($entry)) {
            return response()->notfound();
        }
        if (!empty($entry->exited_at)) {
            return response()->badrequest(null, 'この避難者はすでに退場済です');
        }
        $this->disaster_entry_service->in($id);
    }

    /**
     * 災害 - 受付 - 退場
     */
    public function exit($id)
    {
        $entry = $this->disaster_entry_service->show($id);
        if (empty($entry)) {
            return response()->notfound();
        }
        if (!empty($entry->exited_at)) {
            return response()->badrequest(null, 'この避難者はすでに退場済です');
        }
        return new DisasterEntryResource($this->disaster_entry_service->exit($id));
    }
}
