<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Region;

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

    // 新增員工
    public function newEmployee(Request $request)
    {
        $region = Region::orderBy('sort')->get();

        return view('organization.employee.newEmployee', ['region' => $region]);
    }

    // 員工列表
    public function employeeList(Request $request)
    {
        return view('organization.employee.employeeList');
    }

    // 權限設定
    public function permissions(Request $request)
    {
        return view('organization.employee.permissions');
    }

    // 公司管理
    public function company(Request $request)
    {
        return view('organization.company');
    }
}
