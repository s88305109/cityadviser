<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SystemSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('system_setting')->insert([
            'system' => 'login',
            'system_desc' => '登入系統',
            'code' => 'error_locked_time',
            'code_desc' => '輸入錯誤次數過多鎖定時間（單位分鐘）',
            'value' => '30'
        ]);

        DB::table('system_setting')->insert([
            'system' => 'login',
            'system_desc' => '登入系統',
            'code' => 'error_locked_account',
            'code_desc' => '帳號輸入錯誤達幾次鎖定',
            'value' => '5'
        ]);
    }
}
