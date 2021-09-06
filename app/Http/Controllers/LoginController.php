<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    // 登入畫面首頁
    public function show()
    {
        return view('login/login');
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
            if (Hash::check($request->input('user_password'), $user->user_password)) {
                session(['user_number' => $user->user_number]);
                session(['user_id' => $user->user_id]);
  
                DB::table('user')
                    ->where('user_id', $user->user_id)
                    ->update(['login_time' => date('Y/m/d H:i:s'), 'sign_out_time' => date('Y/m/d H:i:s')]);
            } else {
                $request->session()->forget('user_number');

                return redirect()->back()->withInput()->withErrors(['user_password' => '密碼錯誤']);
            }
        } else {
            $request->session()->forget('user_number');

            return redirect()->back()->withInput()->withErrors(['user_number' => '帳號錯誤']);
        }

        return redirect('/');
    }

    // 登出
    public function logout()
    {
        $request->session()->forget('user_number');

        return redirect('/login');
    }
}
