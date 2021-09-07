<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CaptchaServiceController;
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

Route::get('/', function () {
    return view('/home/home');
});

Route::view('/style', 'style');

// Login 登入系統
Route::get('/login', [LoginController::class, 'show']);                             // 登入介面
Route::post('/login', [LoginController::class, 'verification']);                    // 驗證帳號
Route::get('/logout', [LoginController::class, 'logout']);                          // 登出
Route::get('/reload-captcha', [CaptchaServiceController::class, 'reloadCaptcha']);  // 重刷驗證碼

// User 使用者頁面：個人資料、登出
Route::get('/user', [UserController::class, 'index']);                              // 個人資料頁面
Route::get('/user/information', [UserController::class, 'show']);                   // 個人資料頁面
Route::post('/user/information', [UserController::class, 'changePassword']);        // 修改密碼
