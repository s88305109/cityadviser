<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
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
        $company = Company::orderBy('sort')->get();             // 公司資料
        $region = Region::orderBy('sort')->get();               // 縣市資料
        $job1 = Job::where('type', 1)->orderBy('sort')->get();  // 總公司職務
        $job2 = Job::where('type', 2)->orderBy('sort')->get();  // 分公司職務

        return view('organization.employee.newEmployee', [
            'region'  => $region,
            'company' => $company,
            'job1'    => $job1,
            'job2'    => $job2
        ]);
    }

    // 新增員工 (保存)
    public function addEmployee(Request $request)
    {
        $errors = [];

        if (empty($request->input('name')))
            $errors['name'] = __('請輸入姓名');
        if (empty($request->input('id_card')))
            $errors['id_card'] = __('請輸入身分證');
        if (empty($request->input('phone_number')))
            $errors['phone_number'] = __('請輸入手機號碼');
        if (empty($request->input('email')))
            $errors['email'] = __('請輸入Email');
        else if (! filter_var($request->input('email'), FILTER_VALIDATE_EMAIL))
            $errors['email'] = __('Email格式錯誤');
        if (empty($request->input('date_employment')))
            $errors['date_employment'] =  __('請輸入到職日期');
        if (is_null($request->input('gender_type')))
            $errors['gender_type'] = __('請選擇性別');
        if (empty($request->input('counties_city_type'))) 
            $errors['counties_city_type'] = __('請選擇縣市');
        if (empty($request->input('company_id'))) 
            $errors['company_id'] = __('請選擇所屬公司');
        if (empty($request->input('job_id'))) 
            $errors['job_id'] = __('請選擇職位');
        if (empty($request->input('user_number'))) 
            $errors['user_number'] = __('請輸入平台帳號');

        if (User::where('user_number', $request->input('user_number'))->count() > 0)
            $errors['user_number'] = __('此帳號已存在，請使用不同的帳號名稱。');

        $company = Company::where('company_id', $request->input('company_id'))->first();

        if (! empty($company) && $company->type == 1 && empty($request->input('staff_code')))
            $errors['staff_code'] = __('總公司員工請輸入員工編號');
        else if (! empty($request->input('staff_code')) && User::where('staff_code', $request->input('staff_code'))->count() > 0)
            $errors['staff_code'] = __('此員工編號已重複！');

        // 密碼格式驗證
        $verifyMsg = User::passwordRuleVerify($request->input('user_password'));
        if ($verifyMsg != 'OK')
            $errors['user_password'] = $verifyMsg;

        if (count($errors) > 0)
            return redirect()->back()->withInput()->withErrors($errors);

        // 取不重複的亂數UID
        do {
            $uid = Str::random(16);
        } while(User::where('user_uid', $uid)->count() > 0);

        $user = new User;
        $user->user_uid           = $uid;
        $user->user_number        = $request->input('user_number');
        $user->user_password      = Hash::make($request->input('user_password'));
        $user->name               = $request->input('name');
        $user->id_card            = $request->input('id_card');
        $user->phone_number       = $request->input('phone_number');
        $user->email              = $request->input('email');
        $user->date_employment    = $request->input('date_employment');
        $user->gender_type        = $request->input('gender_type');
        $user->counties_city_type = $request->input('counties_city_type');
        $user->company_id         = $request->input('company_id');
        $user->job_id             = $request->input('job_id');
        $user->status             = 1;
        $user->staff_code         = ($company->type == 1 && ! empty($request->input('staff_code'))) ? $request->input('staff_code') : null;
        $user->save();

        return redirect('/organization/employee/employeeList');
    }

    // 員工列表 (在職中)
    public function employeeList(Request $request)
    {
        $users = User::whereNull('date_resignation')->orderBy('date_employment')->get();

        return view('organization.employee.employeeList', ['users' => $users]);
    }

    // 員工列表 (已離職)
    public function leaversList(Request $request)
    {
        $users = User::whereNotNull('date_resignation')->orderBy('date_resignation', 'desc')->get();

        return view('organization.employee.employeeList', ['users' => $users]);
    }

    // 編輯員工資料
    public function modifyEmployee(Request $request)
    {
        $user = User::where('user_id', $request->userId)->first();

        $company = Company::orderBy('sort')->get();             // 公司資料
        $region = Region::orderBy('sort')->get();               // 縣市資料
        $job1 = Job::where('type', 1)->orderBy('sort')->get();  // 總公司職務
        $job2 = Job::where('type', 2)->orderBy('sort')->get();  // 分公司職務

        return view('organization.employee.modifyEmployee', [
            'user'    => $user,
            'region'  => $region,
            'company' => $company,
            'job1'    => $job1,
            'job2'    => $job2
        ]);
    }

    // 編輯員工資料 (保存)
    public function saveModify(Request $request)
    {
        $errors = [];

        if (empty($request->input('user_id')))
            $errors['user_id'] = __('遺失使用者資料，請重新操作。');
        if (empty($request->input('name')))
            $errors['name'] = __('請輸入姓名');
        if (empty($request->input('id_card')))
            $errors['id_card'] = __('請輸入身分證');
        if (empty($request->input('phone_number')))
            $errors['phone_number'] = __('請輸入手機號碼');
        if (empty($request->input('email')))
            $errors['email'] = __('請輸入Email');
        else if (! filter_var($request->input('email'), FILTER_VALIDATE_EMAIL))
            $errors['email'] = __('Email格式錯誤');
        if (empty($request->input('date_employment')))
            $errors['date_employment'] =  __('請輸入到職日期');
        else if (! empty($request->input('date_resignation')) && strtotime($request->input('date_resignation')) < strtotime($request->input('date_employment')))
            $errors['date_resignation'] =  __('離職日期不可小於到職日期');
        else if (! empty($request->input('date_resignation')) && empty($request->input('reason')))
            $errors['reason'] =  __('請輸入離職原因');
        if (is_null($request->input('gender_type')))
            $errors['gender_type'] = __('請選擇性別');
        if (empty($request->input('counties_city_type'))) 
            $errors['counties_city_type'] = __('請選擇縣市');
        if (empty($request->input('company_id'))) 
            $errors['company_id'] = __('請選擇所屬公司');
        if (empty($request->input('job_id'))) 
            $errors['job_id'] = __('請選擇職位');
        if (empty($request->input('user_number'))) 
            $errors['user_number'] = __('請輸入平台帳號');
        else {
            $checkUser = User::where('user_number', $request->input('user_number'))->first();
            if (! empty($checkUser) && $checkUser->user_id != $request->input('user_id'))
                $errors['user_number'] = __('此帳號已存在，請使用不同的帳號名稱。');
        }

        $company = Company::where('company_id', $request->input('company_id'))->first();

        // 若是總公司員工則檢查員工編號
        if (! empty($company) && $company->type == 1) {
            if (empty($request->input('staff_code')))
                $errors['staff_code'] = __('總公司員工請輸入員工編號');
            else {
                $checkUser = User::where('staff_code', $request->input('staff_code'))->first();
                
                if (! empty($checkUser) && $checkUser->user_id != $request->input('user_id'))
                $errors['staff_code'] = __('此員工編號已重複！');
            }
        }

        // 密碼格式驗證
        if(! empty($request->input('user_password'))) {
            $verifyMsg = User::passwordRuleVerify($request->input('user_password'));

            if ($verifyMsg != 'OK')
                $errors['user_password'] = $verifyMsg;
        }

        if (count($errors) > 0)
            return redirect()->back()->withInput()->withErrors($errors);

        $user = User::find($request->input('user_id'));
        $user->user_number        = $request->input('user_number');
        $user->name               = $request->input('name');
        $user->id_card            = $request->input('id_card');
        $user->phone_number       = $request->input('phone_number');
        $user->email              = $request->input('email');
        $user->date_employment    = $request->input('date_employment');
        $user->date_resignation   = $request->input('date_resignation');
        $user->reason             = $request->input('reason');
        $user->gender_type        = $request->input('gender_type');
        $user->counties_city_type = $request->input('counties_city_type');
        $user->company_id         = $request->input('company_id');
        $user->job_id             = $request->input('job_id');
        $user->status             = 1;
        $user->staff_code         = ($company->type == 1 && ! empty($request->input('staff_code'))) ? $request->input('staff_code') : null;

        if (! empty($request->input('user_password')))
            $user->user_password = Hash::make($request->input('user_password'));

        $user->save();

        if ($request->input('routeName') == 'auth.leaversList')
            return redirect('/organization/employee/leaversList');
        else    
            return redirect('/organization/employee/employeeList');
    }

    // 編輯員工資料 (凍結帳號)
    public function lockUser(Request $request)
    {
        $errors = [];

        if (empty($request->input('user_id')))
            $errors['user_id'] = __('遺失使用者資料，請重新操作。');

        if (count($errors) > 0)
            return redirect()->back()->withInput()->withErrors($errors);

        $user = User::find($request->input('user_id'));
        $user->status = 0;
        $user->save();

        if ($request->input('routeName') == 'auth.leaversList')
            return redirect('/organization/employee/leaversList');
        else    
            return redirect('/organization/employee/employeeList');
    }

    // 編輯員工資料 (解除凍結)
    public function unlockUser(Request $request)
    {
        $errors = [];

        if (empty($request->input('user_id')))
            $errors['user_id'] = __('遺失使用者資料，請重新操作。');

        if (count($errors) > 0)
            return redirect()->back()->withInput()->withErrors($errors);

        $user = User::find($request->input('user_id'));
        $user->status = 1;
        $user->save();

        if ($request->input('routeName') == 'auth.leaversList')
            return redirect('/organization/employee/leaversList');
        else    
            return redirect('/organization/employee/employeeList');
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

    // 新增公司
    public function newCompany(Request $request)
    {
        $region = Region::orderBy('sort')->get(); // 縣市資料

        return view('organization.company.newCompany', ['region' => $region]);
    }

    // 新增公司 (保存)
    public function addCompany(Request $request)
    {
        $errors = [];

        if (empty($request->input('company_name')))
            $errors['company_name'] = __('請輸入公司名稱');
        if (empty($request->input('company_address')))
            $errors['company_address'] = __('請輸入公司地址');
        if (empty($request->input('company_no')))
            $errors['company_no'] = __('請輸入公司統一編號');
        if (empty($request->input('phone_number')))
            $errors['phone_number'] = __('請輸入公司電話');
        if (empty($request->input('company_city')))
            $errors['company_city'] = __('請選擇縣市');
        if (empty($request->input('company_mail')))
            $errors['company_mail'] = __('請輸入公司Email');
        else if (! filter_var($request->input('company_mail'), FILTER_VALIDATE_EMAIL))
            $errors['company_mail'] = __('Email格式錯誤');
        if (empty($request->input('company_bank_id')))
            $errors['company_bank_id'] = __('請輸入公司銀行代號');
        if (empty($request->input('company_bank_account')))
            $errors['company_bank_account'] = __('請輸入公司銀行帳戶');

        $company = new Company;
        $company->company_name         = $request->input('company_name');
        $company->company_address      = $request->input('company_address');
        $company->company_no           = $request->input('company_no');
        $company->phone_number         = $request->input('phone_number');
        $company->company_city         = $request->input('company_city');
        $company->company_mail         = $request->input('company_mail');
        $company->company_bank_id      = $request->input('company_bank_id');
        $company->company_bank_account = $request->input('company_bank_account');
        $company->type                 = 2;
        $company->status               = 1;
        $company->save();

        return redirect('/organization/company/companyList');
    }

    // 公司列表 (北部)
    public function northList(Request $request)
    {
        $companys = Company::getAreaRecord('北部');

        return view('organization.company.companyList', ['companys' => $companys]);
    }

    // 公司列表 (中部)
    public function centralList(Request $request)
    {
        $companys = Company::getAreaRecord('中部');

        return view('organization.company.companyList', ['companys' => $companys]);
    }

    // 公司列表 (南部)
    public function southList(Request $request)
    {
        $companys = Company::getAreaRecord('南部');

        return view('organization.company.companyList', ['companys' => $companys]);
    }

    // 公司列表 (東部)
    public function eastList(Request $request)
    {
        $companys = Company::getAreaRecord('東部');

        return view('organization.company.companyList', ['companys' => $companys]);
    }

    // 公司列表 (離島)
    public function islandList(Request $request)
    {
        $companys = Company::getAreaRecord('離島');

        return view('organization.company.companyList', ['companys' => $companys]);
    }

    // 編輯公司資料
    public function modifyCompany(Request $request)
    {
        $company = Company::where('company_id', $request->companyId)->first();
        $region = Region::orderBy('sort')->get(); // 縣市資料

        return view('organization.company.modifyCompany', [
            'region'  => $region,
            'company' => $company
        ]);
    }

    // 編輯公司資料 (保存)
    public function saveCompany(Request $request)
    {
        $errors = [];

        if (empty($request->input('company_name')))
            $errors['company_name'] = __('請輸入公司名稱');
        if (empty($request->input('company_address')))
            $errors['company_address'] = __('請輸入公司地址');
        if (empty($request->input('company_no')))
            $errors['company_no'] = __('請輸入公司統一編號');
        if (empty($request->input('phone_number')))
            $errors['phone_number'] = __('請輸入公司電話');
        if (empty($request->input('company_city')))
            $errors['company_city'] = __('請選擇縣市');
        if (empty($request->input('company_mail')))
            $errors['company_mail'] = __('請輸入公司Email');
        else if (! filter_var($request->input('company_mail'), FILTER_VALIDATE_EMAIL))
            $errors['company_mail'] = __('Email格式錯誤');
        if (empty($request->input('company_bank_id')))
            $errors['company_bank_id'] = __('請輸入公司銀行代號');
        if (empty($request->input('company_bank_account')))
            $errors['company_bank_account'] = __('請輸入公司銀行帳戶');

        $company = Company::find($request->input('company_id'));
        $company->company_name         = $request->input('company_name');
        $company->company_address      = $request->input('company_address');
        $company->company_no           = $request->input('company_no');
        $company->phone_number         = $request->input('phone_number');
        $company->company_city         = $request->input('company_city');
        $company->company_mail         = $request->input('company_mail');
        $company->company_bank_id      = $request->input('company_bank_id');
        $company->company_bank_account = $request->input('company_bank_account');
        $company->type                 = 2;
        $company->status               = 1;
        $company->save();

        return redirect('/organization/company/'.$request->input('routeName'));
    }

}
