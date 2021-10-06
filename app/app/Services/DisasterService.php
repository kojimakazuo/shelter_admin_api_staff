<?php

namespace App\Services;

use App\Enums\Condition;
use App\Models\Disaster;
use App\Models\DisasterShelter;
use Illuminate\Support\Facades\DB;

class DisasterService
{
    /**
     * 災害一覧
     */
    public function find()
    {
        $query = Disaster::select('*');
        return $query->get();
    }

    /**
     * 災害詳細
     */
    public function show($id)
    {
        $query = Disaster::select('*');
        $query->where('id', $id);
        return $query->first();
    }

    /**
     * 災害登録
     */
    public function add($request)
    {
        $disaster = DB::transaction(function () use ($request) {
            $disaster = new Disaster($request);
            $disaster->save();
            $this->addShelters($disaster, $request['shelters'], 'id');
            return $disaster;
        });
        return $disaster;
    }

    /**
     * 災害更新
     */
    public function update($request, $id)
    {
        $disaster = $this->show($id);
        if (empty($disaster)) {
            return;
        }
        DB::transaction(function () use ($request, $disaster) {
            // Disaster
            $disaster->fill($request);
            $disaster->save();
            // DisasterShelters
            $newDisasterShelters = $request['disaster_shelters'];
            foreach ($disaster->disasterShelters as &$disasterShelter) {
                // 登録済の災害避難所がリクエストデータにあるか検索する
                $index = array_search($disasterShelter->id, array_column($newDisasterShelters, 'id'));
                if ($index !== FALSE) {
                    // ある場合は利用可能&更新する
                    $this->updateShelterCondition($disasterShelter->id, Condition::AVAILABLE);
                    $this->updateShelter($disasterShelter, $newDisasterShelters[$index]);
                    continue;
                }
                // ない場合は利用不可にする
                $this->updateShelterCondition($disasterShelter->id, Condition::UNAVAILABLE);
            }
            unset($disasterShelter);

            $this->addShelters($disaster, array_filter($newDisasterShelters, function ($e) use ($disaster) {
                // idがnull & shelter_idが重複していないデータは登録
                $index = array_search($e['shelter_id'], array_column($disaster->shelters->all(), 'id'));
                return empty($e['id']) && $index === FALSE;
            }), 'shelter_id');
            return $disaster;
        });
        return $this->show($disaster->id);
    }

    /**
     * 災害避難所閉鎖
     */
    public function close($id)
    {
        $disaster = $this->show($id);
        if (empty($disaster)) {
            return;
        }
        $disaster->end_at = now();
        $disaster->save();
        return $this->show($disaster->id);
    }

    /**
     * 災害避難所再開
     */
    public function reopen($id)
    {
        $disaster = $this->show($id);
        if (empty($disaster)) {
            return;
        }
        $disaster->end_at = null;
        $disaster->save();
        return $this->show($disaster->id);
    }

    /**
     * 災害削除
     */
    public function delete($id)
    {
        $disaster = $this->show($id);
        if (empty($disaster)) {
            return;
        }
        $disaster->deleted_by = auth()->user()->id;
        return $disaster->delete();
    }

    /**
     * 現在発生中の災害詳細
     */
    public function current()
    {
        $query = Disaster::select('*');
        $query->where('start_at', '<=', now()); // 開始日が現在日時以降
        $query->whereNull('end_at'); // 終了していない
        return $query->first();
    }

    /**
     * 現在発生中の災害か否か
     */
    public function isOccurring($id)
    {
        $current = $this->current();
        return isset($current) ? $current->id == $id : false;
    }

    /**
     * 現在発生中もしくは発生前の災害があるか
     */
    public function isBeforeOrOccurring($exclude_id)
    {
        $query = Disaster::select('*');
        $query->whereNull('end_at'); // 終了していない
        if ($exclude_id) {
            $query->where('id', '!=', $exclude_id); // 除外ID
        }
        return count($query->get()) > 0;
    }

    /**
     * 災害避難所詳細
     */
    public function showShelter($id)
    {
        $query = DisasterShelter::select('*');
        $query->where('id', $id);
        return $query->first();
    }

    /**
     * 利用可能な災害避難所か
     */
    public function availableShelter($id)
    {
        $query = DisasterShelter::select('*');
        $query->where('id', $id);
        $query->where('condition', Condition::AVAILABLE);
        return $query->first() != null;
    }

    /**
     * 災害避難所登録(一括)
     */
    public function addShelters(Disaster $disaster, $shelters, $shelter_id_key)
    {
        $disasterShelters = array_map(function ($e) use ($disaster, $shelter_id_key) {
            $disasterShelter = new DisasterShelter($e);
            $disasterShelter->disaster_id = $disaster->id;
            $disasterShelter->shelter_id = $e[$shelter_id_key];
            $disasterShelter->start_at = $disaster->start_at;
            return $disasterShelter;
        }, $shelters);
        $disaster->disasterShelters()->saveMany($disasterShelters);
    }

    /**
     * 災害避難所更新
     */
    public function updateShelter($shelter, $newShelter)
    {
        $shelter->fill($newShelter);
        $shelter->save();
    }


    /**
     * 災害避難所利用可否変更
     */
    public function updateShelterCondition($id, $condition)
    {
        $shelter = $this->showShelter($id);
        if (empty($shelter)) {
            return;
        }
        $shelter->condition = $condition;
        $shelter->save();
    }
}
