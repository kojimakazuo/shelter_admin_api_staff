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
                'name' => '東部小学校',
                'name_kana' => 'とうぶしょうがっこう',
                'postal_code' => '100-0001',
                'address' => '東京都千代田区千代田1-1-1',
                'phone_number' => '03-0000-0000',
                'latitude' => 139.414331,
                'longitude' => 35.857783,
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
                'name' => '南部小学校',
                'name_kana' => 'なんぶしょうがっこう',
                'postal_code' => '100-0001',
                'address' => '東京都千代田区千代田1-1-1',
                'phone_number' => '03-0000-0000',
                'latitude' => 139.414331,
                'longitude' => 35.857783,
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
                'name' => '西部小学校',
                'name_kana' => 'せいぶしょうがっこう',
                'postal_code' => '100-0001',
                'address' => '東京都千代田区千代田1-1-1',
                'phone_number' => '03-0000-0000',
                'latitude' => 139.414331,
                'longitude' => 35.857783,
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
                'name' => '北部小学校',
                'name_kana' => 'ほくぶしょうがっこう',
                'postal_code' => '100-0001',
                'address' => '東京都千代田区千代田1-1-1',
                'phone_number' => '03-0000-0000',
                'latitude' => 139.414331,
                'longitude' => 35.857783,
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
                'name' => '削除小学校',
                'name_kana' => 'さくじょしょうがっこう',
                'postal_code' => '100-0001',
                'address' => '東京都千代田区千代田1-1-1',
                'phone_number' => '03-0000-0000',
                'latitude' => 139.414331,
                'longitude' => 35.857783,
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
