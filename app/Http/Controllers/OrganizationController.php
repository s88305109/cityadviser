<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    // 主頁
    public function index(Request $request)
    {
        return view('organization.organization');
    }

    // 員工管理
    public function employee(Request $request)
    {
        return view('organization.employee');
    }

    // 公司管理
    public function company(Request $request)
    {
        return view('organization.company');
    }
}
