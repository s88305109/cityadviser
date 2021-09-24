<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CaptchaServiceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrganizationController;

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

Route::get('/test', function () {
    echo substr('auth.employeeList', 5);
});

// 首頁
Route::get('/', function () {
    if (Auth::check()) 
        return redirect()->route('auth.home');
    else 
        return redirect()->route('login');
});

// Login 登入系統
Route::get('/login', [LoginController::class, 'show'])->name('login');              // 登入介面
Route::post('/check', [LoginController::class, 'check']);                           // 檢查帳號
Route::post('/check2', [LoginController::class, 'check2']);                         // 檢查密碼
Route::post('/login', [LoginController::class, 'verification']);                    // 驗證登入資訊
Route::get('/logout', [LoginController::class, 'logout']);                          // 登出
Route::get('/reload-captcha', [CaptchaServiceController::class, 'reloadCaptcha']);  // 重刷驗證碼

// Error 錯誤控制頁面
Route::view('/errors/unauthorized', 'errors.unauthorized');

// 需登入驗證頁面
Route::middleware(['auth'])->name('auth.')->group(function () {
    // Home 主畫面 & 副畫面 選單
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/home2', [HomeController::class, 'home2'])->name('home2');

    // User 使用者頁面：個人資料、登出
    Route::get('/user', [UserController::class, 'index']);                           // 個人資料頁面
    Route::get('/user/information', [UserController::class, 'information']);         // 個人資料頁面
    Route::post('/user/information', [UserController::class, 'changePassword']);     // 修改密碼

    // Organization 組織
    Route::get('/organization', [OrganizationController::class, 'index']);                                  // 組織管理

    Route::get('/organization/employee', [OrganizationController::class, 'employee']);                      // 員工管理
    Route::get('/organization/employee/newEmployee', [OrganizationController::class, 'newEmployee']);       // 新增員工
    Route::post('/organization/employee/newEmployee', [OrganizationController::class, 'addEmployee']);      // 新增員工 (保存)

    // 員工列表 (在職中)
    Route::get('/organization/employee/employeeList', [OrganizationController::class, 'employeeList'])->name("employeeList");
    // 員工列表 (已離職)
    Route::get('/organization/employee/leaversList', [OrganizationController::class, 'leaversList'])->name("leaversList");
    // 編輯員工資料 (在職中)
    Route::get('/organization/employee/employeeList/{userId}', [OrganizationController::class, 'modifyEmployee'])->name("employeeList");
    // 編輯員工資料 (已離職)
    Route::get('/organization/employee/leaversList/{userId}', [OrganizationController::class, 'modifyEmployee'])->name("leaversList");

    Route::post('/organization/employee/modifyEmployee', [OrganizationController::class, 'saveModify']);     // 編輯員工資料 (保存)
    Route::post('/organization/employee/lockUser', [OrganizationController::class, 'lockUser']);             // 編輯員工資料 (凍結帳號)
    Route::post('/organization/employee/unlockUser', [OrganizationController::class, 'unlockUser']);         // 編輯員工資料 (解除凍結)
    Route::get('/organization/employee/permissions', [OrganizationController::class, 'permissions']);        // 權限設定

    Route::get('/organization/company', [OrganizationController::class, 'company']);                         // 公司管理
    Route::get('/organization/company/newCompany', [OrganizationController::class, 'newCompany']);           // 新增公司
    Route::post('/organization/company/newCompany', [OrganizationController::class, 'addCompany']);          // 新增公司 (保存)
    
    // 公司列表 (北部)
    Route::get('/organization/company/northList', [OrganizationController::class, 'northList'])->name('northList');
    Route::get('/organization/company/northList/{companyId}', [OrganizationController::class, 'modifyCompany'])->name('northList');
    // 公司列表 (中部)
    Route::get('/organization/company/centralList', [OrganizationController::class, 'centralList'])->name('centralList');
    Route::get('/organization/company/centralList/{companyId}', [OrganizationController::class, 'modifyCompany'])->name('centralList');
    // 公司列表 (南部)
    Route::get('/organization/company/southList', [OrganizationController::class, 'southList'])->name('southList');
    Route::get('/organization/company/southList/{companyId}', [OrganizationController::class, 'modifyCompany'])->name('southList');
    // 公司列表 (東部)
    Route::get('/organization/company/eastList', [OrganizationController::class, 'eastList'])->name('eastList');
    Route::get('/organization/company/eastList/{companyId}', [OrganizationController::class, 'modifyCompany'])->name('eastList');
    // 公司列表 (離島)
    Route::get('/organization/company/islandList', [OrganizationController::class, 'islandList'])->name('islandList');
    Route::get('/organization/company/islandList/{companyId}', [OrganizationController::class, 'modifyCompany'])->name('islandList');
    // 編輯公司資料 (保存)
    Route::post('/organization/company/saveCompany', [OrganizationController::class, 'saveCompany']);

});
