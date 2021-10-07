<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CompanySeeder::class,
            EventSeeder::class,
            JobSeeder::class,
            RegionSeeder::class,
            RoleSeeder::class,
            SystemSettingSeeder::class,
            UserSeeder::class
        ]);
    }
}
