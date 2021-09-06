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
            'user_uid' => 'KGwCrb5u5dSmkstw',
            'user_number' => 'user01',
            'user_password' => Hash::make('user01'),
            'status' => '1'
        ]);
    }
}
