<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Region;
use App\Models\Job;
use App\Models\Company;
use App\Models\Permission;
use App\Services\OrganizationService;

class OrganizationController extends Controller
{
    // 主頁
    public function index(Request $request)
    {
        if (Auth::user()->hasPermission('employee') & ! Auth::user()->hasPermission('company')) 
            return redirect('/organization/employee');
        else if (! Auth::user()->hasPermission('employee') & Auth::user()->hasPermission('company')) 
            return redirect('/organization/company');

        return view('organization.index');
    }

    // 員工管理
    public function employee(Request $request)
    {
        return view('organization.employee');
    }

    // 新增員工
    public function new(Request $request)
    {
        $user    = new User;
        $company = Company::where('status', 1)->orderBy('sort')->get();                // 公司資料
        $region  = Region::orderBy('sort')->get();                                     // 縣市資料
        $job1    = Job::where('type', 1)->where('status', 1)->orderBy('sort')->get();  // 總公司職務
        $job2    = Job::where('type', 2)->where('status', 1)->orderBy('sort')->get();  // 分公司職務

        return view('organization.employee.edit', [
            'state'   => $request->state,
            'user'    => $user,
            'region'  => $region,
            'company' => $company,
            'job1'    => $job1,
            'job2'    => $job2
        ]);
    }

    // 員工列表
    public function employeeList(Request $request)
    {
        $users = User::getEmployees($request->state, 1, 'user.staff_code', 'desc', 20, 1);

        return view('organization.employee.employeeList', ['state' => $request->state, 'users' => $users , 'offset' => 0]);
    }

    // 員工列表 (載入更多)
    public function moreEmployee(Request $request)
    {
        sleep(0.5);

        $page   = ! empty($request->page) ? $request->page : 1;
        $per    = 20;
        $offset = ($page - 1) * $per;
        $users  = User::getEmployees($request->state, 1, 'user.staff_code', 'desc', 20, 1);

        return view('organization.employee.each', ['state' => $request->state, 'users' => $users , 'offset' => $offset]);
    }

    // 編輯員工資料
    public function modifyEmployee(Request $request)
    {
        $user = User::find($request->userId);

        $company = Company::orderBy('sort')->get();                                    // 公司資料
        $region  = Region::orderBy('sort')->get();                                     // 縣市資料
        $job1    = Job::where('type', 1)->where('status', 1)->orderBy('sort')->get();  // 總公司職務
        $job2    = Job::where('type', 2)->where('status', 1)->orderBy('sort')->get();  // 分公司職務

        return view('organization.employee.edit', [
            'state'   => $request->state,
            'user'    => $user,
            'region'  => $region,
            'company' => $company,
            'job1'    => $job1,
            'job2'    => $job2
        ]);
    }

    // 編輯員工資料 (保存)
    public function save(Request $request)
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
        else {
            $date = date_parse($request->input('date_employment'));
            if ($date['error_count'] > 0 || ! checkdate($date['month'], $date['day'], $date['year'])) 
                $errors['date_employment'] =  __('到職日期格式錯誤');            
        }
        if (! empty($request->input('date_resignation'))) {
            $date = date_parse($request->input('date_resignation'));
            if ($date['error_count'] > 0 || ! checkdate($date['month'], $date['day'], $date['year'])) 
                $errors['date_resignation'] =  __('離職日期格式錯誤');            
        }
        else if (! empty($request->input('date_resignation')) && strtotime($request->input('date_resignation')) < strtotime($request->input('date_employment')))
            $errors['date_resignation'] =  __('離職日期不可小於到職日期');
        if (! empty($request->input('date_resignation')) && empty($request->input('reason')))
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
        else if (User::where('user_number', $request->input('user_number'))->where('user_id', '!=', $request->input('user_id'))->count() > 0)
            $errors['user_number'] = __('此帳號已存在，請使用不同的帳號名稱。');
        if (empty($request->input('user_id')) && empty($request->input('user_password')))
            $errors['user_password'] = __('請輸入平台密碼');

        $company = Company::find($request->input('company_id'));
        $region = ! empty($company->company_city) ? Region::find($company->company_city) : null;

        // 若是總公司員工則檢查員工編號
        if (! empty($company) && $company->type == 1) {
            if (empty($request->input('staff_code')))
                $errors['staff_code'] = __('總公司員工請輸入員工編號');
            else if (User::where('staff_code', $request->input('staff_code'))->where('user_id', '!=', $request->input('user_id'))->count() > 0)
                $errors['staff_code'] = __('此員工編號已重複！');
        }

        // 密碼格式驗證
        if(! empty($request->input('user_password'))) {
            $verifyMsg = User::passwordRuleVerify($request->input('user_password'));

            if ($verifyMsg != 'OK')
                $errors['user_password'] = $verifyMsg;
        }

        if (count($errors) > 0)
            return redirect()->back()->withInput()->withErrors($errors);

        $user = new User;

        if (! empty($request->input('user_id'))) {
            $user = User::find($request->input('user_id'));
            $principalCheck = Company::where('principal', $user->user_id)->first();

            if ($user->status != 1)
                return redirect()->back()->withInput()->withErrors(['user_id' => __('帳號已凍結，不可編輯資料。')]);
            else if ($request->input('company_id') != $user->company_id & ! empty($principalCheck))
                return redirect()->back()->withInput()->withErrors(['user_id' => __('此員工是'.$principalCheck->company_name.'的負責人，不能變更所屬公司。')]);
            else if ($request->input('job_id') != $user->job_id & ! empty($principalCheck))
                return redirect()->back()->withInput()->withErrors(['user_id' => __('此員工是'.$principalCheck->company_name.'的負責人，不能變更職位。')]);
        } else {
            // 取不重複的亂數做UID
            do {
                $uid = Str::random(16);
            } while(User::where('user_uid', $uid)->count() > 0);

            $user->user_uid   = $uid;
            $user->status     = 1;

            // 若是新增員工且是公司負責人則先檢查該公司是否已有任命負責人
            if($request->input('job_id') == 15 && ! empty($company->principal)) {
                return redirect()->back()->withInput()->withErrors(['user_id' => __($company->company_name.'已有公司負責人，不能重複設定負責人。')]);
            }
        }

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
        $user->staff_code         = ($company->type == 1 && ! empty($request->input('staff_code'))) ? $request->input('staff_code') : null;

        if (! empty($request->input('user_password')))
            $user->user_password = Hash::make($request->input('user_password'));

        if (! empty($request->input('date_resignation')))
            $user->status = 0;

        $user->save();

        // 若新增員工且指定為負責人 則一併自動變更公司負責人ID
        if($request->input('job_id') == 15 && empty($company->principal)) {
            $company->principal = $user->user_id;
            $company->save();
        }

        $state = (! empty($request->input('state'))) ? $request->input('state') : 'on';

        if ($company->type == 1)
            return redirect('/organization/employee/list/'.$state);
        else
            return redirect('/organization/company/'.$region->area.'/'.$request->input('company_id').'/people/'.$state);
    }

    // 編輯員工資料 (凍結帳號)
    public function lockUser(Request $request)
    {
        $errors = [];

        if (empty($request->input('user_id')))
            $errors['user_id'] = __('遺失使用者資料，請重新操作。');

        if (count($errors) > 0)
            return redirect()->back()->withInput()->withErrors($errors);

        $user    = User::find($request->input('user_id'));
        $company = Company::find($user->company_id);
        $region  = Region::find($company->company_city);

        $user->status = 0;
        $user->save();

        if ($company->type == 1)
            return redirect('/organization/employee/list/'.$request->input('state'));
        else
            return redirect('/organization/company/'.$region->area.'/'.$user->company_id.'/people/'.$request->input('state'));
    }

    // 編輯員工資料 (解除凍結)
    public function unlockUser(Request $request)
    {
        $errors = [];

        if (empty($request->input('user_id')))
            $errors['user_id'] = __('遺失使用者資料，請重新操作。');

        $user    = User::find($request->input('user_id'));
        $company = Company::find($user->company_id);
        $region  = Region::find($company->company_city);

        if (! empty($user->date_resignation))
            $errors['user_id'] = __('該員工已離職，不可解除凍結。');

        if (count($errors) > 0)
            return redirect()->back()->withInput()->withErrors($errors);

        $user->status = 1;
        $user->save();

        if ($company->type == 1)
            return redirect('/organization/employee/list/'.$request->input('state'));
        else
            return redirect('/organization/company/'.$region->area.'/'.$user->company_id.'/people/'.$request->input('state'));
    }

    // 個人權限設定
    public function role(Request $request)
    {
        $user       = User::find($request->userId);
        $permission = Permission::getUserPermission($request->userId);
        $job        = Job::find($user->job_id);
        $roles      = (! empty($job)) ? OrganizationService::getRoles($job->type) : array();

        if (empty($permission))
            $permission = Permission::getJobPermission($user->job_id);

        return view('organization.employee.role', [
            'state'      => $request->state,
            'user'       => $user, 
            'permission' => $permission,
            'roles'      => $roles
        ]);
    }

    // 個人權限設定 (保存)
    public function saveRole(Request $request)
    {
        $user    = User::find($request->input('user_id'));
        $company = Company::find($user->company_id);
        $region  = Region::find($company->company_city);

        Permission::updateUserPermission($request->input('user_id'), $request->input('role'));

        if ($company->type == 1)
            return redirect('/organization/employee/list/'.$request->input('state'));
        else
            return redirect('/organization/company/'.$region->area.'/'.$user->company_id.'/people/'.$request->input('state'));
    }

    // 權限設定
    public function permissions(Request $request)
    {
        $jobId      = $request->jobId;
        $job        = Job::find($jobId);
        $jobs       = Job::where('status', 1)->orderBy('type')->orderBy('sort')->get();
        $permission = Permission::getJobPermission($jobId);
        $roles      = (! empty($job)) ? OrganizationService::getRoles($job->type) : array();

        return view('organization.employee.permissions', [
            'jobId'      => $jobId, 
            'jobs'       => $jobs,
            'permission' => $permission,
            'roles'      => $roles
        ]);
    }

    // 權限設定 (保存)
    public function savePermissions(Request $request)
    {
        Permission::updateJobPermission($request->input('job_id'), $request->input('role'));

        return redirect('/organization/employee');
    }

    // 公司管理
    public function company(Request $request)
    {
        $areas = Company::getAreas();
        $first = empty(reset($areas)) ? '南部' : reset($areas);

        return view('organization.company', ['first' => $first]);
    }

    // 新增公司
    public function newCompany(Request $request)
    {
        $company  = new Company;
        $managers = User::where('job_id', 14)->orderBy('user_id')->get();   // 區經理資料
        $region   = Region::orderBy('sort')->get();                         // 縣市資料

        return view('organization.company.edit', [
            'company'  => $company,
            'area'     => null,
            'managers' => $managers, 
            'region'   => $region
        ]);
    }

    // 公司列表
    public function companyList(Request $request)
    {
        $areas    = Company::getAreas();
        $area     = empty($request->area) ? '南部' : $request->area;
        $companys = Company::getAreaRecord($area);

        return view('organization.company.companyList', ['area' => $area, 'areas' => $areas, 'companys' => $companys]);
    }

    // 公司列表 載入更多
    public function moreCompany(Request $request)
    {
        sleep(0.5);

        $page   = ! empty($request->page) ? $request->page : 1;
        $area     = empty($request->area) ? '南部' : $request->area;
        $companys = Company::getAreaRecord($area, $page);

        return view('organization.company.each', ['area' => $area, 'companys' => $companys]);
    }

    // 編輯公司資料
    public function modifyCompany(Request $request)
    {
        $company = Company::find($request->companyId);

        $managers = User::where('job_id', 14)->orderBy('user_id')->get();   // 區經理資料
        $region = Region::orderBy('sort')->get();                           // 縣市資料

        $company->principal_name = (! empty($company->principal)) ? User::find($company->principal)->name : '';

        return view('organization.company.edit', [
            'area'     => $request->area,
            'managers' => $managers,
            'region'   => $region,
            'company'  => $company
        ]);
    }

    // 編輯公司資料 (保存)
    public function saveCompany(Request $request)
    {
        $errors = [];

        if (empty($request->input('area_manager')))
            $errors['area_manager'] = __('請選擇通路區經理');
        if (! empty($request->input('principal')) && Company::where('principal', $request->input('principal'))->where('status', 1)->where('company_id', '!=', $request->input('company_id'))->count() > 0)
            $errors['principal_name'] = __('此人已是其他公司的負責人，不可同時負責兩間公司。');
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

        if (count($errors) > 0)
            return redirect()->back()->withInput()->withErrors($errors);

        $company = new Company;

        if (! empty($request->input('company_id'))) {
            $company = Company::find($request->input('company_id'));

            if ($company->status != 1)
                return redirect()->back()->withInput()->withErrors(['company_id' => __('公司已凍結，不可編輯資料。')]);

            // 若負責人變更則修改原本負責人的職位改為員工
            if (! empty($company->principal) && $company->principal != $request->input('principal')) {
                $user = User::find($company->principal);
                if (! empty($user)) {
                    $user->job_id = 16;
                    $user->save();
                }
            }

            // 將新負責人的職位自動變為負責人
            $user = User::find($request->input('principal'));
            if (! empty($user)) {
                $user->job_id = 15;
                $user->save();
            }
        } else {
            $company->type   = 2;
            $company->status = 1;
        }

        $company->area_manager         = $request->input('area_manager');
        $company->principal            = $request->input('principal');
        $company->company_name         = $request->input('company_name');
        $company->company_address      = $request->input('company_address');
        $company->company_no           = $request->input('company_no');
        $company->phone_number         = $request->input('phone_number');
        $company->company_city         = $request->input('company_city');
        $company->company_mail         = $request->input('company_mail');
        $company->company_bank_id      = $request->input('company_bank_id');
        $company->company_bank_account = $request->input('company_bank_account');
        $company->save();

        $region = Region::find($company->company_city);
        $area = ! empty($request->input('area')) ? $request->input('area') : $region->area;

        return redirect('/organization/company/'.$area);
    }

    // 編輯公司資料 (凍結公司)
    public function lockCompany(Request $request)
    {
        $errors = [];

        if (empty($request->input('company_id')))
            $errors['company_id'] = __('遺失使用者資料，請重新操作。');

        if (count($errors) > 0)
            return redirect()->back()->withInput()->withErrors($errors);

        $company = Company::find($request->input('company_id'));
        $company->status = 0;
        $company->save();

        return redirect('/organization/company/'.$request->input('area'));
    }

    // 編輯員工資料 (解除凍結)
    public function unlockCompany(Request $request)
    {
        $errors = [];

        if (empty($request->input('company_id')))
            $errors['company_id'] = __('遺失使用者資料，請重新操作。');

        if (count($errors) > 0)
            return redirect()->back()->withInput()->withErrors($errors);

        $company = Company::find($request->input('company_id'));
        $company->status = 1;
        $company->save();

        return redirect('/organization/company/'.$request->input('area'));
    }

    // 公司員工列表
    public function companyPeople(Request $request)
    {
        $company = Company::find($request->companyId);
        $users   = User::getEmployees($request->state, $request->companyId, 'user.date_employment', 'desc', 20, 1);

        return view('organization.company.companyPeople', [
            'company'   => $company,
            'area'      => $request->area, 
            'companyId' => $request->companyId, 
            'state'     => $request->state, 
            'users'     => $users,
            'offset'    => 0
        ]);
    }

    // 公司員工列表 (載入更多)
    public function morePeople(Request $request)
    {
        sleep(0.5);

        $page   = ! empty($request->page) ? $request->page : 1;
        $per    = 20;
        $offset = ($page - 1) * $per;

        $company = Company::find($request->companyId);
        $users   = User::getEmployees($request->state, $request->companyId, 'user.date_employment', 'desc', $per, $page);

        return view('organization.company.people-each', [
            'company'   => $company,
            'area'      => $request->area, 
            'companyId' => $request->companyId, 
            'state'     => $request->state, 
            'users'     => $users,
            'offset'    => $offset
        ]);
    }

    // 編輯員工資料 (分公司)
    public function modifyPeople(Request $request)
    {
        $user = User::where('user_id', $request->userId)->first();

        $company = Company::orderBy('sort')->get();                                 // 公司資料
        $region = Region::orderBy('sort')->get();                                   // 縣市資料
        $job1 = Job::where('type', 1)->where('status', 1)->orderBy('sort')->get();  // 總公司職務
        $job2 = Job::where('type', 2)->where('status', 1)->orderBy('sort')->get();  // 分公司職務

        return view('organization.employee.edit', [
            'area'      => $request->area,
            'companyId' => $request->companyId,
            'state'     => $request->state,
            'user'      => $user,
            'region'    => $region,
            'company'   => $company,
            'job1'      => $job1,
            'job2'      => $job2
        ]);
    }

    // 查找區經理
    public function findUser(Request $request)
    {
        sleep(0.5);

        if (empty($request->input('principal_name')))
            return null;

        $users = User::where('name', 'like', '%'.$request->input('principal_name').'%')
            ->select('user_id', 'name')
            ->get();

        return response()->json($users);
    }

}
