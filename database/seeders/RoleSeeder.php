<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::insert([
            // 總公司權限
            [ 'role_id' => 1, 'parent' => null, 'role' => 'organization', 'title' => '組織管理', 'type' => 1, 'sort' => 1 ],
            [ 'role_id' => 2, 'parent' => 1,    'role' => 'employee',     'title' => '員工管理', 'type' => 1, 'sort' => 1 ],
            [ 'role_id' => 3, 'parent' => 1,    'role' => 'company',      'title' => '公司管理', 'type' => 1, 'sort' => 2 ],
            [ 'role_id' => 4, 'parent' => null, 'role' => 'case',         'title' => '報件管理', 'type' => 1, 'sort' => 2 ],
            [ 'role_id' => 5, 'parent' => 4,    'role' => 'present',      'title' => '案件報件', 'type' => 1, 'sort' => 1 ],
            [ 'role_id' => 6, 'parent' => null, 'role' => 'review',       'title' => '報件審查', 'type' => 1, 'sort' => 3 ],
            //分公司權限
            [ 'role_id' => 7, 'parent' => null, 'role' => 'case',         'title' => '報件管理', 'type' => 2, 'sort' => 1 ],
            [ 'role_id' => 8, 'parent' => 7,    'role' => 'present',      'title' => '案件報件', 'type' => 3, 'sort' => 1 ],
            [ 'role_id' => 9, 'parent' => null, 'role' => 'staff',        'title' => '員工管理', 'type' => 2, 'sort' => 2 ],
        ]);
    }
}
