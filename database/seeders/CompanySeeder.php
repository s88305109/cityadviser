<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::insert([
            [ 
                'type'         => 1, 
                'company_name' => '總公司', 
                'company_city' => '64000', 
                'principal'    => 1, 
                'status'       => 1, 
                'sort'         => 0, 
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s') 
            ]
        ]);
    }
}
