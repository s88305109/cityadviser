<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    // 主頁
    public function index(Request $request)
    {
        return view('/user/user');
    }

    // 個人資料頁面
    public function show(Request $request)
    {
        $user = User::where('user_id', $request->session()->get('user_id'))->first();

        return view('/user/information', ['user' => $user]);
    }

    // 修改密碼
    public function changePassword(Request $request)
    {
        $user = User::where('user_id', $request->session()->get('user_id'))->first();

        if (empty($request->input('old_password'))) {
            return redirect()->back()->withInput()->withErrors(['modify_failed' => "請輸入目前密碼"]);
        } else if (empty($request->input('new_password'))) {
            return redirect()->back()->withInput()->withErrors(['modify_failed' => "請輸入新密碼"]);
        } else if (empty($request->input('confirm_password'))) {
            return redirect()->back()->withInput()->withErrors(['modify_failed' => "請輸入確認新密碼"]);
        } else if (! Hash::check($request->input('old_password'), $user->user_password)) {
            return redirect()->back()->withInput()->withErrors(['old_password' => "舊密碼不正確"]);
        } else if ($request->input('new_password') <> $request->input('confirm_password')) {
            return redirect()->back()->withInput()->withErrors(['confirm_password' => "新密碼與確認新密碼不相同"]);
        }

        DB::table('user')
            ->where('user_id', $request->session()->get('user_id'))
            ->update(['user_password' => Hash::make($request->input('new_password'))]);

        return redirect('/user');
    }
}
