<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\CaptchaServiceController;
use App\Http\Controllers\LoginController;

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
    $data = session()->all();

    echo date('Y/m/d H:i:s');

    echo '<pre>';
    print_r($data);
    echo '</pre>';

    //return view('welcome');
});


// Login 登入系統
Route::get('/login', [LoginController::class, 'show']);                             // 登入介面
Route::post('/login', [LoginController::class, 'verification']);                    // 驗證帳號
Route::get('/logout', [LoginController::class, 'logout']);                          // 登出
Route::get('/reload-captcha', [CaptchaServiceController::class, 'reloadCaptcha']);  // 重刷驗證碼
