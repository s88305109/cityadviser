<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Region;
use App\Models\Job;
use App\Models\Company;

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
        $company = Company::orderBy('sort')->get();
        $region = Region::orderBy('sort')->get();
        $job1 = Job::where('type', 1)->orderBy('sort')->get();
        $job2 = Job::where('type', 2)->orderBy('sort')->get();

        return view('organization.employee.newEmployee', [
            'region' => $region,
            'company' => $company,
            'job1' => $job1,
            'job2' => $job2
        ]);
    }

    // 新增員工 (保存)
    public function addEmployee(Request $request)
    {
        $errors = [];

        if (empty($request->input('fullname')))
            $errors['fullname'] = __('請輸入姓名');
        if (empty($request->input('id_card')))
            $errors['id_card'] = __('請輸入身分證');
        if (empty($request->input('phone_number')))
            $errors['phone_number'] = __('請輸入手機號碼');
        if (empty($request->input('email')))
            $errors['email'] = __('請輸入Email');
        if (empty($request->input('date_employment')))
            $errors['date_employment'] =  __('請輸入到職日期');
        if (empty($request->input('gender_type')))
            $errors['gender_type'] = __('請選擇性別');
        if (empty($request->input('counties_city_type'))) 
            $errors['counties_city_type'] = __('請選擇縣市');
        if (empty($request->input('company_id'))) 
            $errors['company_id'] = __('請選擇所屬公司');
        if (empty($request->input('job_id'))) 
            $errors['job_id'] = __('請選擇職位');
        if (empty($request->input('user_name'))) 
            $errors['user_name'] = __('請輸入平台帳號');

        if (count($errors) > 0)
            return redirect()->back()->withInput()->withErrors($errors);


        return redirect('//organization/employee/employeeList');
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
