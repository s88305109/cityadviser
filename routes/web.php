<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CaptchaServiceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/dump', function () {
    //DB::table('user')->where('user_number', 'user01')->update(['user_password' => Hash::make('12345678')]);

    echo '<pre>';

    if (Auth::check())
        echo "User ID is : ".Auth::user()->user_id."<br>";

    echo "<hr>Session Dump :<br><br>";
    $data = session()->all();
    print_r($data);


    echo "<hr>Auth User Dump :<br><br>";
    print_r(Auth::user());

    if (Auth::check()) {
        echo 'logged in';
    } else {
        echo 'not login';
    }
});
Route::view('style', 'style');

// 首頁
Route::get('/', [HomeController::class, 'index']);

// Login 登入系統
Route::get('/login', [LoginController::class, 'show'])->name('login');              // 登入介面
Route::post('/check', [LoginController::class, 'check']);                           // 檢查帳號
Route::post('/check2', [LoginController::class, 'check2']);                         // 檢查密碼
Route::post('/login', [LoginController::class, 'verification']);                    // 驗證登入資訊
Route::get('/logout', [LoginController::class, 'logout']);                          // 登出
Route::get('/reload-captcha', [CaptchaServiceController::class, 'reloadCaptcha']);  // 重刷驗證碼

// User 使用者頁面：個人資料、登出
Route::get('/user', [UserController::class, 'index']);                              // 個人資料頁面
Route::get('/user/information', [UserController::class, 'information']);            // 個人資料頁面
Route::post('/user/information', [UserController::class, 'changePassword']);        // 修改密碼
