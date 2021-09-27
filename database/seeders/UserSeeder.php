<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user')->insert([
            'user_uid'        => 'KGwCrb5u5dSmkstw',
            'user_number'     => 'user01',
            'user_password'   => Hash::make('a1234567'),
            'name'            => 'user01',
            'company_id'      => 1,
            'job_id'          => 12,
            'date_employment' => date('Y-m-d H:i:s'),
            'staff_code'      => 'user01',
            'admin'           => 1,
            'status'          => '1',
            'created_at'      => date('Y-m-d H:i:s')
        ]);

        DB::table('user')->insert([
            'user_uid'        => 'VTfgy5y8dvrTaztA',
            'user_number'     => 'user02',
            'user_password'   => Hash::make('a1234567'),
            'name'            => 'user02',
            'company_id'      => 1,
            'job_id'          => 12,
            'date_employment' => date('Y-m-d H:i:s'),
            'staff_code'      => 'user02',
            'admin'           => 0,
            'status'          => '1',
            'created_at'      => date('Y-m-d H:i:s')
        ]);
    }
}
