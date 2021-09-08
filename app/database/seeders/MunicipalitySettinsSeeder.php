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
                'name' => 'シェアクレスト',
                'latitude' => 35.70159568124503,
                'longitude' => 139.76673776968042,
                'created_by' => 1,
                'updated_by' => 1,
            ],
        ]);
    }
}
