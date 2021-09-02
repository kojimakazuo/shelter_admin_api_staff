<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SheltersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shelters')->insert([
            [
                'name' => '御茶ノ水駅',
                'name_kana' => 'おちゃのみずえき',
                'postal_code' => '113-0034',
                'address' => '東京都文京区湯島１丁目５',
                'phone_number' => '03-0000-0000',
                'latitude' => 35.700698284936024,
                'longitude' => 139.76430232400557,
                'type' => 'Normal',
                'target_disaster_types' => 'Rockfall',
                'capacity' => '100',
                'facility_info' => 'エアコン\nストーブ',
                'staff_user_id' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => null,
                'deleted_by' => null,
            ],
            [
                'name' => '東京医科歯科大学 歯学部附属病院',
                'name_kana' => 'とうきょういかしかだいがく',
                'postal_code' => '113-0034',
                'address' => '東京都文京区湯島１丁目５−４５',
                'phone_number' => '03-0000-0000',
                'latitude' => 35.701032977935256,
                'longitude' => 139.76497283563745,
                'type' => 'Normal',
                'target_disaster_types' => 'Rockfall',
                'capacity' => '100',
                'facility_info' => 'エアコン\nストーブ',
                'staff_user_id' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => null,
                'deleted_by' => null,
            ],
            [
                'name' => 'ファミリーマート 清水坂下店',
                'name_kana' => 'ふぁみりーまーと',
                'postal_code' => '113-0034',
                'address' => '東京都文京区湯島３丁目１−９',
                'phone_number' => '03-0000-0000',
                'latitude' => 35.70313732402929,
                'longitude' => 139.766821971949,
                'type' => 'Normal',
                'target_disaster_types' => 'Rockfall',
                'capacity' => '100',
                'facility_info' => 'エアコン\nストーブ',
                'staff_user_id' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => null,
                'deleted_by' => null,
            ],
            [
                'name' => 'デジタルハリウッド大学',
                'name_kana' => 'でじたるはりうっどだいがく',
                'postal_code' => '101-0062',
                'address' => '東京都千代田区神田駿河台４−６ 御茶ノ水ソラシティアカデミア 3F/4F',
                'phone_number' => '03-0000-0000',
                'latitude' => 35.69888926277374,
                'longitude' => 139.76630949518125,
                'type' => 'Normal',
                'target_disaster_types' => 'Rockfall',
                'capacity' => '100',
                'facility_info' => 'エアコン\nストーブ',
                'staff_user_id' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => null,
                'deleted_by' => null,
            ],
            [
                'name' => '三楽病院',
                'name_kana' => 'さくじょしょうがっこう',
                'postal_code' => '101-8326',
                'address' => '東京都千代田区神田駿河台2−５',
                'phone_number' => '03-0000-0000',
                'latitude' => 35.700365509350426,
                'longitude' => 139.761126711266,
                'type' => 'Normal',
                'target_disaster_types' => 'Rockfall',
                'capacity' => '100',
                'facility_info' => 'エアコン\nストーブ',
                'staff_user_id' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => now(),
                'deleted_by' => 1,
            ],
        ]);
    }
}
