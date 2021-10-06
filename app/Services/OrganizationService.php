<?php

namespace App\Services;

use Route;
use Request;
use Illuminate\Support\Facades\Auth;

class OrganizationService 
{
	// 權限參數設定
    public static function getRoles($type) {
        $roles = [];

        if ($type == 1) {
            // 總公司權限
            $roles = [
                'organization' => ['title' => '組織管理', 
                    'child' => [
                        'employee' => ['title' => '員工管理'], 
                        'company'  => ['title' => '公司管理']
                    ]
                ],
                'case' => ['title' => '報件管理', 
                    'child' => [
                        'present' => ['title' => '案件報件']
                    ]
                ],
                'review' => ['title' => '報件審查']
            ];
        } else if ($type == 2) {
            // 分公司權限
            $roles = [
                'case' => ['title' => '報件管理', 
                    'child' => [
                        'present' => ['title' => '案件報件']
                    ]
                ],
                'staff' => ['title' => '員工管理']
            ];
        }

        return $roles;
    }

}
