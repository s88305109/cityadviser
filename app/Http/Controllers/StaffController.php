<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Pagination\Paginator;
use App\Models\User;
use App\Models\Region;
use App\Models\Job;
use App\Models\Company;

class StaffController extends Controller
{
    // 主頁
    public function index(Request $request)
    {
        return view('staff.index');
    }

    // 新增員工
    public function new(Request $request)
    {
        $user    = new User;
        $company = Company::find(Auth::user()->company_id);     // 公司資料
        $region  = Region::orderBy('sort')->get();              // 縣市資料
        $job     = Job::where('type', $company->type)           // 分公司職務
                    ->where('status', 1)
                    ->orderBy('sort')
                    ->get();   

        return view('staff.edit', [
            'state'   => null,
            'user'    => $user,
            'company' => $company,
            'region'  => $region,
            'job'     => $job
        ]);
    }

    // 新增員工 (保存)
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
        else if (! empty($request->input('date_resignation')) && strtotime($request->input('date_resignation')) < strtotime($request->input('date_employment')))
            $errors['date_resignation'] =  __('離職日期不可小於到職日期');
        else if (! empty($request->input('date_resignation')) && empty($request->input('reason')))
            $errors['reason'] =  __('請輸入離職原因');
        if (is_null($request->input('gender_type')))
            $errors['gender_type'] = __('請選擇性別');
        if (empty($request->input('counties_city_type'))) 
            $errors['counties_city_type'] = __('請選擇縣市');
        if (empty($request->input('job_id'))) 
            $errors['job_id'] = __('請選擇職位');
        if (empty($request->input('user_number'))) 
            $errors['user_number'] = __('請輸入平台帳號');
        else if (User::where('user_number', $request->input('user_number'))->where('user_id', '!=', $request->input('user_id'))->count() > 0)
            $errors['user_number'] = __('此帳號已存在，請使用不同的帳號名稱。');
        if (empty($request->input('user_id')) && empty($request->input('user_password')))
            $errors['user_password'] = __('請輸入平台密碼');

        // 密碼格式驗證
        if (! empty($request->input('user_password'))) {
            $verifyMsg = User::passwordRuleVerify($request->input('user_password'));
            if ($verifyMsg != 'OK')
                $errors['user_password'] = $verifyMsg;
        }

        if (count($errors) > 0)
            return redirect()->back()->withInput()->withErrors($errors);

        $user = new User;

        if (! empty($request->input('user_id'))) {
            $user = User::find($request->input('user_id'));

            // 檢查是否為同公司的員工
            if (Auth::user()->company_id != $user->company_id)
                abort(500);
            else if ($user->status != 1)
                return redirect()->back()->withInput()->withErrors(['user_id' => __('帳號已凍結，不可編輯資料。')]);
        } else {
            // 取不重複的亂數做UID
            do {
                $uid = Str::random(16);
            } while(User::where('user_uid', $uid)->count() > 0);

            $user->user_uid   = $uid;
            $user->status     = 1;
            $user->company_id = Auth::user()->company_id;
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
        $user->job_id             = $request->input('job_id');

        if (! empty($request->input('user_password')))
            $user->user_password = Hash::make($request->input('user_password'));

        if (! empty($request->input('date_resignation')))
            $user->status = 0;

        $user->save();

        return redirect('/staff/'.( ! empty($request->input('state')) ? $request->input('state') : 'on'));
    }

    // 員工列表
    public function list(Request $request)
    {
        if ($request->state == 'left') {
            // 已離職
            $users = User::join('company', 'company.company_id', '=', 'user.company_id')
                ->whereNotNull('user.date_resignation')
                ->where('user.company_id', Auth::user()->company_id)
                ->where('user.user_number', '!=', 'user01')
                ->select('user.*', 'company.company_name')
                ->orderBy('user.date_resignation', 'desc')
                ->offset(0)
                ->limit(20)
                ->get();
        } else {
            // 未離職
            $users = User::join('company', 'company.company_id', '=', 'user.company_id')
                ->whereNull('user.date_resignation')
                ->where('user.company_id', Auth::user()->company_id)
                ->where('user.user_number', '!=', 'user01')
                ->select('user.*', 'company.company_name')
                ->orderBy('user.date_employment')
                ->offset(0)
                ->limit(20)
                ->get();
        }

        return view('staff.list', ['state' => $request->state, 'users' => $users, 'offset' => 0]);
    }

    // 員工列表 (載入更多)
    public function more(Request $request)
    {
        $page   = ! empty($request->page) ? $request->page : 1;
        $per    = 20;
        $offset = ($page - 1) * $per;

        if ($request->state == 'left') {
            // 已離職
            $users = User::join('company', 'company.company_id', '=', 'user.company_id')
                ->whereNotNull('user.date_resignation')
                ->where('user.company_id', Auth::user()->company_id)
                ->where('user.user_number', '!=', 'user01')
                ->select('user.*', 'company.company_name')
                ->orderBy('user.date_resignation', 'desc')
                ->offset($offset)
                ->limit($per)
                ->get();
        } else {
            // 未離職
            $users = User::join('company', 'company.company_id', '=', 'user.company_id')
                ->whereNull('user.date_resignation')
                ->where('user.company_id', Auth::user()->company_id)
                ->where('user.user_number', '!=', 'user01')
                ->select('user.*', 'company.company_name')
                ->orderBy('user.date_employment')
                ->offset($offset)
                ->limit($per)
                ->get();
        }

        return view('staff.each', ['state' => $request->state, 'users' => $users, 'offset' => $offset]);
    }

    // 編輯員工資料
    public function modify(Request $request)
    {
        $user    = User::find($request->userId);
        $company = Company::find(Auth::user()->company_id); // 公司資料
        $region  = Region::orderBy('sort')->get();          // 縣市資料
        $job     = Job::where('type', $company->type)       // 分公司職務
                    ->where('status', 1)
                    ->orderBy('sort')
                    ->get();

        // 檢查是否為同公司的員工
        if (Auth::user()->company_id != $user->company_id)
            abort(403);

        return view('staff.edit', [
            'state'   => $request->state,
            'user'    => $user,
            'company' => $company,
            'region'  => $region,
            'job'     => $job
        ]);
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

        // 檢查是否為同公司的員工
        if (Auth::user()->company_id != $user->company_id)
            abort(403);

        $user->status = 0;
        $user->save();

        return redirect('/staff/'.$request->input('state'));
    }

    // 編輯員工資料 (解除凍結)
    public function unlockUser(Request $request)
    {
        $errors = [];

        if (empty($request->input('user_id')))
            $errors['user_id'] = __('遺失使用者資料，請重新操作。');

        $user    = User::find($request->input('user_id'));
        $company = Company::find($user->company_id);

        if (! empty($user->date_resignation))
            $errors['user_id'] = __('該員工已離職，不可解除凍結。');

        if (count($errors) > 0)
            return redirect()->back()->withInput()->withErrors($errors);

        $user->status = 1;
        $user->save();

        return redirect('/staff/'.$request->input('state'));
    }

}
