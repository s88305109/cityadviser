<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Company;
use App\Models\Job;

class UserController extends Controller
{    
    // 主頁
    public function index(Request $request)
    {
        return view('user.user');
    }

    // 個人資料頁面
    public function information(Request $request)
    {
        $user    = Auth::user();
        $company = Company::find($user->company_id);
        $job     = Job::find($user->job_id);

        return view('user.information', [
            'user'    => $user,
            'company' => $company,
            'job'     => $job
        ]);
    }

    // 修改密碼
    public function changePassword(Request $request)
    {
        $user = Auth::user();

        if (empty($request->input('old_password'))) {
            return redirect()->back()->withInput()->withErrors(['modify_failed' => __('請輸入目前密碼')]);
        } else if (empty($request->input('new_password'))) {
            return redirect()->back()->withInput()->withErrors(['modify_failed' => __('請輸入新密碼')]);
        } else if (empty($request->input('confirm_password'))) {
            return redirect()->back()->withInput()->withErrors(['modify_failed' => __('請輸入確認新密碼')]);
        } else if (! Hash::check($request->input('old_password'), $user->user_password)) {
            return redirect()->back()->withInput()->withErrors(['old_password' => __('目前密碼輸入錯誤')]);
        } else if ($request->input('new_password') <> $request->input('confirm_password')) {
            return redirect()->back()->withInput()->withErrors(['confirm_password' => __('新密碼與確認新密碼不相同')]);
        } 

        // 密碼格式驗證
        $verifyMsg = User::passwordRuleVerify($request->input('new_password'));
        if ($verifyMsg != 'OK')
            return redirect()->back()->withInput()->withErrors(['new_password' => $verifyMsg]);

        Auth::user()->update(['user_password' => Hash::make($request->input('new_password'))]);

        return redirect('/user');
    }
}
