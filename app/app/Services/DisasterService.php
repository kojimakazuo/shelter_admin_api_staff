<?php

namespace App\Services;

use App\Models\Disaster;
use App\Models\DisasterShelter;

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
        // TODO: transaction
        $disaster = new Disaster($request);
        $disaster->save();
        $this->addShelters($disaster, $request['shelters'], 'id');
        return $disaster;
    }

    /**
     * 災害更新
     */
    public function update($request, $id)
    {
        // TODO: transaction
        $disaster = $this->show($id);
        if (empty($disaster)) {
            return;
        }
        $disaster->fill($request);
        $disaster->save();

        $disasterShelters = $disaster->disasterShelters;
        $newDisasterShelters = $request['disaster_shelters'];
        foreach ($disasterShelters as &$disasterShelter) {
            $index = array_search($disasterShelter->id, array_column($newDisasterShelters, 'id'));
            if ($index !== FALSE) {
                // idがある場合は更新
                $this->updateShelter($disasterShelter, $newDisasterShelters[$index]);
                continue;
            }
            // 更新データリストにidがない場合は削除
            $this->deleteShelter($disasterShelter->id);
        }
        unset($disasterShelter);

        $this->addShelters($disaster, array_filter($newDisasterShelters, function($e) use ($disaster) {
            // idがnull & shelter_idが重複していないデータは登録
            $index = array_search($e['shelter_id'], array_column($disaster->shelters->all(), 'id'));
            return empty($e['id']) && $index === FALSE;
        }), 'shelter_id');

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
     * 災害避難所詳細
     */
    public function showShelter($id)
    {
        $query = DisasterShelter::select('*');
        $query->where('id', $id);
        return $query->first();
    }

    /**
     * 災害避難所登録(一括)
     */
    public function addShelters(Disaster $disaster, $shelters, $shelter_id_key)
    {
        $disasterShelters = array_map(function($e) use ($disaster, $shelter_id_key) {
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
     * 災害避難所削除
     */
    public function deleteShelter($id)
    {
        $shelter = $this->showShelter($id);
        if (empty($shelter)) {
            return;
        }
        $shelter->deleted_by = auth()->user()->id;
        return $shelter->delete();
    }
}
