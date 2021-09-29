<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Company;
use App\Models\User;
use App\Models\SystemSetting;
use App\Models\AuthenticationLog;

class LoginController extends Controller 
{
	// 登入畫面首頁
	public function show() 
	{
		return view('login.login');
	}

	// 檢查是否短時間內密碼錯誤超過限制次數
	public function checkLock($user) 
	{
		$incorrect_count = SystemSetting::where('code', 'error_locked_account')->first();
		$lock_minutes = SystemSetting::where('code', 'error_locked_time')->first();

		$lock_check = AuthenticationLog::where('user_id', $user->user_id)
			->where('action', 'user_lock')
			->where('log_time', '>=', date('Y-m-d H:i:s', strtotime("-{$lock_minutes->value} minutes")))
			->count();

		if ($lock_check > 0) {
			return true;
		} else {
			$incorrect_check = AuthenticationLog::where('user_id', $user->user_id)
				->where('action', 'incorrect_password')
				->where('log_time', '>=', date('Y-m-d H:i:s', strtotime('-10 minutes')))
				->count();

			if ($incorrect_check >= $incorrect_count->value) {
				AuthenticationLog::insert([
					'user_id'  => $user->user_id,
					'action'   => 'user_lock',
					'log_time' => date('Y-m-d H:i:s')
				]);

				return true;
			}
		}

		return false;
	}

	// 檢查帳號
	public function check(Request $request) 
	{
		$rules     = ['user_number' => 'required'];
		$messages  = ['user_number.required' =>  __('請輸入帳號')];
		$validated = $request->validate($rules, $messages);

		$user      = User::where('user_number', $request->input('user_number'))->first();
		$company   = Company::find($user->company_id);
		$principal = User::find($company->principal);

		if (empty($user)) {
			return response()->json([
				'status'  => 'fail', 
				'message' => __('帳號錯誤'), 
				'code'    => 40001
			], 400);
		} else if ($user->status != 1 || $company->status != 1 || $principal->status != 1 || ! empty($user->date_resignation)) {
			// 若User狀態已被凍結 或 所屬公司已被凍結 或 所屬公司負責人帳號被凍結 或帳號已離職 就禁止登入
			return response()->json([
				'status'  => 'fail', 
				'message' => __('此帳號已被凍結'), 
				'code'    => 40002
			], 400);
		} else if ($this->checkLock($user)) {
			$lock_minutes = SystemSetting::where('code', 'error_locked_time')->first();

			return response()->json([
				'status'  => 'fail', 
				'code'    => 40003,
				'message' => __("輸入錯誤次數過多，將鎖定{$lock_minutes->value}分鐘。")
			], 400);
		}

		return response()->json([
			'status'  => 'success', 
			'message' => '', 
			'code'    => 20000
		], 200);
	}

	// 檢查密碼
	public function check2(Request $request) 
	{
		$rules = [
			'user_number'   => 'required',
			'user_password' => 'required'
		];
		$messages = [
			'user_number.required'   => __('請輸入帳號'),
			'user_password.required' => __('請輸入密碼')
		];
		$validated = $request->validate($rules, $messages);

		$user = User::where('user_number', $request->input('user_number'))->first();

		$response = ['status' => 'fail', 'message' => ''];

		if (empty($user)) {
			return response()->json([
				'status'  => 'fail', 
				'code'    => 40001,
				'message' => __('帳號錯誤')
			], 400);
		} else if ($user->status != 1) {
			return response()->json([
				'status'  => 'fail', 
				'code'    => 40002,
				'message' => __('此帳號已被凍結')
			], 400);
		} else if ($this->checkLock($user)) {
			$lock_minutes = SystemSetting::where('code', 'error_locked_time')->first();

			return response()->json([
				'status'  => 'fail', 
				'code'    => 40003,
				'message' => __("輸入錯誤次數過多，將鎖定{$lock_minutes->value}分鐘。")
			], 400);
		}

		if (! Hash::check($request->input('user_password'), $user->user_password)) {
			// 紀錄使用者密碼錯誤紀錄
			AuthenticationLog::insert([
				'user_id'  => $user->user_id,
				'action'   => 'incorrect_password',
				'log_time' => date('Y-m-d H:i:s')
			]);

			return response()->json([
				'status'  => 'fail', 
				'code'    => 40004,
				'message' => __('密碼錯誤')
			], 400);
		}

		return response()->json([
			'status'  => 'success', 
			'code'    => 20000,
			'message' => '' 
		], 200);
	}

	// 使用者登入帳號驗證
	public function verification(Request $request) 
	{
		$rules = [
			'user_number'   => 'required',
			'user_password' => 'required',
			'captcha'       => 'required|captcha'
		];

		$messages = [
			'user_number.required'   => __('請輸入帳號'),
			'user_password.required' => __('請輸入密碼'),
			'captcha.required'       => __('請輸入驗證碼'),
			'captcha.captcha'        => __('驗證碼錯誤')
		];

		$validated = $request->validate($rules, $messages);

		$user = User::where('user_number', $request->input('user_number'))->first();

		if (empty($user))
			return redirect()->back()->withInput()->withErrors(['user_number' => __('帳號錯誤')]);

		$company = Company::find($user->company_id);
		$principal = User::find($company->principal);

		$incorrect_count = SystemSetting::where('code', 'error_locked_account')->first();
		$lock_minutes = SystemSetting::where('code', 'error_locked_time')->first();

		if ($this->checkLock($user)) {		
			// 檢查是否短時間內密碼錯誤超過限制次數
			$lock_minutes = DB::table('system_setting')->where('code', 'error_locked_time')->first();
			return redirect()->back()->withInput()->withErrors(['user_lock' => __("輸入錯誤次數過多，將鎖定{$lock_minutes->value}分鐘。")]);
		} else if (! Hash::check($request->input('user_password'), $user->user_password)) {		
			// 檢查密碼是否正確若錯誤紀錄使用者密碼錯誤紀錄
			AuthenticationLog::insert([
				'user_id'  => $user->user_id,
				'action'   => 'incorrect_password',
				'log_time' => date('Y-m-d H:i:s')
			]);

			return redirect()->back()->withInput()->withErrors(['user_password' => __('密碼錯誤')]);
		} else if ($user->status != 1 || $company->status != 1 || $principal->status != 1 || ! empty($user->date_resignation)) {
			// 若User狀態已被凍結 或 所屬公司已被凍結 或 所屬公司負責人帳號被凍結 或帳號已離職 就禁止登入
			return redirect()->back()->withInput()->withErrors(['user_number' => __('此帳號已被凍結')]);
		}

		// 清空此UserID的Session 強制其他裝置登出
		DB::table('sessions')->where('user_id', $user->user_id)->delete();

		Auth::loginUsingId($user->user_id);

		// 記錄使用者最後登入時間
		Auth::user()->update(['login_time' => date('Y/m/d H:i:s'), 'sign_out_time' => date('Y-m-d H:i:s')]);

		return redirect('/home');
	}

	// 登出
	public function logout(Request $request) 
	{
		Auth::logout();

		return redirect('/login');
	}

}
