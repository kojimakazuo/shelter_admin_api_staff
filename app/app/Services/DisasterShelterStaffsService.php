<?php

namespace App\Services;

use App\Models\DisasterSheltersStaffs;
use Illuminate\Support\Facades\DB;

class DisasterShelterStaffsService
{
  
    /**
    *  開設避難所職員詳細
    */
    public function show($staff_user_id)
    {
        $query = DisasterSheltersStaff::select('disaster_shelter_staffs.*');
        //開設中の避難所であること
        $query->join('disaster_shelters', 'disaster_shelters.shelter_id', '=', 'disaster_shelter_staffs.shelter_id');
        $query->where('disaster_shelters.disaster_id', 'disaster_shelter_staffs.disaster_id');
        $query->where('condition', Condition::AVAILABLE);
        $query->where('staff_user_id', $staff_user_id);
        $query->whereNull('end_at');
        return $query->first();
    }
    
     /**
     * 開設避難所職員一覧
     */
    public function test()
    {
        $query = DisasterShelterStaffs::select('*');
        $query->whereNull('end_at');
        return $query->get();
    }

    /**
     * 開設避難所職員一覧
     */
    public function find($shelter_id)
    {
        $query = DisasterShelterStaffs::select('*');
        $query->where('shelter_id', $shelter_id);
        $query->whereNull('end_at');
        return $query->get();
    }

    /**
     * 開設避難所職員登録
     * 他の避難所に登録していた場合はそのレコードは終了日時を入れる
     */
    public function update($request, $staff_user_id)
    {
        $disasterShalterStaffs = $this->show($staff_user_id);
        //スタッフIdで既にデータがあった場合は終了日時を入れる
        if (!empty($disasterShalterStaffs)) {
            $disasterShalterStaffs->end_at = now();
            $disasterShalterStaffs->save();
        }
        $disasterShalterStaffs = new DisasterShelterStaffs($request);
        $disasterShalterStaffs->save();
        return $disasterShalterStaffs;
    }

     /**
     * 開設避難所職員一括撤退（避難所をクローズした場合は、終了日付を全員分入れる）
     * TODO: 実装
     */
}
