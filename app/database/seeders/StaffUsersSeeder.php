<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StaffUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('staff_users')->insert([
            [
                'login_id' => 'admin',
                'password' => bcrypt('password'),
                'name' => '管理者',
                'name_kana' => 'かんりしゃ',
                'phone_number' => '03-0000-0000',
                'role' => 'Admin',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'login_id' => 'user',
                'password' => bcrypt('password'),
                'name' => '一般ユーザ',
                'name_kana' => 'いっぱんゆーざ',
                'phone_number' => '03-0000-0000',
                'role' => 'General',
                'created_by' => 1,
                'updated_by' => 1,
            ]
        ]);
    }
}
