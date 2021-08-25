<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MunicipalitySettinsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('municipality_settings')->insert([
            [
                'name' => 'XX市',
                'latitude' => 35.70162181894888,
                'longitude' => 139.76676995550267,
                'created_by' => 1,
                'updated_by' => 1,
            ],
        ]);
    }
}
