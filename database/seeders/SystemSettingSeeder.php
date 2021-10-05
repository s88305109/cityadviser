<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SystemSetting;

class SystemSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SystemSetting::insert([
            [
                'system'      => 'login',
                'system_desc' => '登入系統',
                'code'        => 'error_locked_time',
                'code_desc'   => '輸入錯誤次數過多鎖定時間（單位分鐘）',
                'value'       => '30'
            ],
            [
                'system'      => 'login',
                'system_desc' => '登入系統',
                'code'        => 'error_locked_account',
                'code_desc'   => '帳號輸入錯誤達幾次鎖定',
                'value'       => '5'
            ]
        ]);
    }
}
