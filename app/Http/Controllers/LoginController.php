<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    // 登入畫面首頁
    public function show()
    {
        return view('login.login');
    }

    public function check(Request $request) 
    {
        $rules = ['user_number' => 'required'];
        $messages = ['user_number.required' => '請輸入帳號'];
        $validated = $request->validate($rules, $messages);

        $user = User::where('user_number', $request->input('user_number'))->first();

        $response = ['status' => 'fail', 'message' => ''];

        if (empty($user)) {
            $response['message'] = '帳號錯誤';
            echo json_encode($response, true);
            die;
        } else if ($user->status <> 1)  {
            $response['message'] = '此帳號已停用';
            echo json_encode($response, true);
            die;
        }

        $response['status'] = 'ok';
        $response['message'] = '';
        echo json_encode($response, true);
    }

    // 使用者登入帳號驗證
    public function verification(Request $request) 
    {
        $rules = [
            'user_number' => 'required',
            'user_password' => 'required',
            'captcha' => 'required|captcha'
        ];

        $messages = [
            'user_number.required' => '請輸入帳號',
            'user_password.required' => '請輸入密碼',
            'captcha.required' => '請輸入驗證碼',
            'captcha.captcha' => '驗證碼錯誤',
        ];

        $validated = $request->validate($rules, $messages);

        $user = User::where('user_number', $request->input('user_number'))->first();

        if (! empty($user)) {
            $incorrect_count = DB::table('system_setting')
                ->where('code', 'error_locked_account')
                ->first();

            $lock_minutes = DB::table('system_setting')
                ->where('code', 'error_locked_time')
                ->first();

            // 檢查是否短時間內密碼錯誤超過限制次數
            $lock_check = DB::table('authentication_log')
                ->where('user_id', $user->user_id)
                ->where('action', 'user_lock')
                ->where('log_time', '>=', date('Y-m-d H:i:s', strtotime("-{$lock_minutes->value} minutes")))
                ->count();

            if ($lock_check > 0) {
                return redirect()->back()->withInput()->withErrors(['user_lock' => "輸入錯誤次數過多，將鎖定{$lock_minutes->value}分鐘。"]);
            } else {
                $incorrect_check = DB::table('authentication_log')
                    ->where('user_id', $user->user_id)
                    ->where('action', 'incorrect_password')
                    ->where('log_time', '>=', date('Y-m-d H:i:s', strtotime('-10 minutes')))
                    ->count();

                if ($incorrect_check >= $incorrect_count->value) {
                    DB::table('authentication_log')->insert([
                        'user_id' => $user->user_id,
                        'action' => 'user_lock',
                        'log_time' => date('Y-m-d H:i:s')
                    ]);

                    return redirect()->back()->withInput()->withErrors(['user_lock' => "輸入錯誤次數過多，將鎖定{$lock_minutes->value}分鐘。"]);
                }
            }

            if (Hash::check($request->input('user_password'), $user->user_password)) {
                if ($user->status <> 1) {
                    return redirect()->back()->withInput()->withErrors(['user_number' => '此帳號已停用']);
                }

                Auth::loginUsingId($user->user_id);
                Auth::logoutOtherDevices($request->input('user_password'), 'user_password');
  
                // 記錄使用者最後登入時間
                DB::table('user')
                    ->where('user_id', $user->user_id)
                    ->update(['login_time' => date('Y/m/d H:i:s'), 'sign_out_time' => date('Y-m-d H:i:s')]);
            } else {
                // 紀錄使用者密碼錯誤紀錄
                DB::table('authentication_log')->insert([
                    'user_id' => $user->user_id,
                    'action' => 'incorrect_password',
                    'log_time' => date('Y-m-d H:i:s')
                ]);

                return redirect()->back()->withInput()->withErrors(['user_password' => '密碼錯誤']);
            }
        } else {
            return redirect()->back()->withInput()->withErrors(['user_number' => '帳號錯誤']);
        }

        return redirect('/');
    }

    // 登出
    public function logout(Request $request)
    {
        Auth::logout();

        return redirect('/login');
    }
}
