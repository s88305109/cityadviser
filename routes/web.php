<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CaptchaServiceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\SecretaryController;

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

// 首頁 (若已登入自動導向到選單頁；若未登入導向到登入頁)
Route::get('/', function () {
    if (Auth::check()) 
        return redirect()->route('auth.home.home');
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
Route::view('/errors/forbidden', 'errors.forbidden');
Route::view('/errors/locked', 'errors.locked');

/*************
|需登入驗證頁面|
**************/
Route::middleware(['auth', 'permission'])->name('auth.')->group(function () {
    // User 使用者頁面：個人資料、登出
    Route::get('/user', [UserController::class, 'index']);                           // 個人資料頁面
    Route::get('/user/information', [UserController::class, 'information']);         // 個人資料頁面
    Route::post('/user/information', [UserController::class, 'changePassword']);     // 修改密碼

    // Secretary 小秘書
    Route::get('/secretary', [SecretaryController::class, 'index']);                 // 小秘書頁面
    Route::get('/secretary/{state}', [SecretaryController::class, 'index']);
    Route::post('/secretary/watch', [SecretaryController::class, 'watch']);          // 事件已讀

    /*
    |--------------------------------------------------------------------------
    | Home 主畫面
    |--------------------------------------------------------------------------
    */
    Route::name('home.')->group(function () {
        /** 主畫面 首頁 **/
        Route::get('/home', [HomeController::class, 'index'])->name('home');

        /** Organization 組織 權限名稱:organization **/
        Route::get('/organization', [OrganizationController::class, 'index'])->middleware('permission:organization'); // 組織管理

        /** 員工管理 權限名稱:employee **/
        Route::middleware('permission:employee')->group(function () {
            // 員工管理
            Route::get('/organization/employee', [OrganizationController::class, 'employee'])->name('organization.employee');
            // 新增員工
            Route::get('/organization/employee/new', [OrganizationController::class, 'new']);
            // 保存員工資料
            Route::post('/organization/employee/save', [OrganizationController::class, 'save']);
            // 員工列表
            Route::redirect('/organization/employee/list', '/organization/employee');
            Route::get('/organization/employee/list/{state}', [OrganizationController::class, 'employeeList']);
            Route::get('/organization/employee/moreEmployee/{state}/{page}', [OrganizationController::class, 'moreEmployee']);
            // 編輯員工資料
            Route::get('/organization/employee/list/{state}/{userId}', [OrganizationController::class, 'modifyEmployee']);
            // 編輯員工資料 (凍結帳號)
            Route::post('/organization/employee/lockUser', [OrganizationController::class, 'lockUser']);
            // 編輯員工資料 (解除凍結)
            Route::post('/organization/employee/unlockUser', [OrganizationController::class, 'unlockUser']);
            // 個人權限設定
            Route::get('/organization/employee/list/{state}/{userId}/role', [OrganizationController::class, 'role']);
            // 個人權限設定 (保存)
            Route::post('/organization/employee/saveRole', [OrganizationController::class, 'saveRole']);
            // 職位權限設定
            Route::get('/organization/employee/permissions', [OrganizationController::class, 'permissions']);
            Route::get('/organization/employee/permissions/{jobId}', [OrganizationController::class, 'permissions']);
            // 職位權限設定 (保存)
            Route::post('/organization/employee/savePermissions', [OrganizationController::class, 'savePermissions']);
        });

        /** 公司管理 權限名稱:company **/
        Route::middleware('permission:company')->group(function () {
            // 公司管理
            Route::get('/organization/company', [OrganizationController::class, 'company'])->name('organization.company');
            // 新增公司
            Route::get('/organization/company/newCompany', [OrganizationController::class, 'newCompany']);
            // 保存公司資料
            Route::post('/organization/company/saveCompany', [OrganizationController::class, 'saveCompany']);
            // 公司列表
            Route::get('/organization/company/{area}', [OrganizationController::class, 'companyList']);
            Route::get('/organization/company/moreCompany/{area}/{page}', [OrganizationController::class, 'moreCompany']);
            // 編輯公司
            Route::get('/organization/company/{area}/{companyId}', [OrganizationController::class, 'modifyCompany']);
            // 員工列表
            Route::redirect('/organization/company/{area}/{companyId}/people', '/organization/company/{area}');
            Route::get('/organization/company/{area}/{companyId}/people/{state}', [OrganizationController::class, 'companyPeople']);
            Route::get('/organization/company/{area}/{companyId}/morePeople/{state}/{page}', [OrganizationController::class, 'morePeople']);
            // 編輯公司資料 (凍結公司)
            Route::post('/organization/company/lockCompany', [OrganizationController::class, 'lockCompany']);
            // 編輯公司資料 (解除凍結)
            Route::post('/organization/company/unlockCompany', [OrganizationController::class, 'unlockCompany']);
            // 編輯員工資料
            Route::get('/organization/company/{area}/{companyId}/people/{state}/{userId}', [OrganizationController::class, 'modifyPeople']);
            // 編輯員工資料 (保存)
            Route::post('/organization/company/savePeople', [OrganizationController::class, 'savePeople']);
            // 查找User公司負責人
            Route::post('/organization/company/findUser', [OrganizationController::class, 'findUser']);
            Route::post('/organization/company/{area}', [OrganizationController::class, 'companyList']);
        });

        /** 員工管理 (分公司負責人管理自己公司內的員工) 權限名稱:staff **/
        Route::middleware('permission:staff')->group(function () {
            // 員工管理 首頁
            Route::get('/staff', [StaffController::class, 'index']);
            // 新增員工
            Route::get('/staff/new', [StaffController::class, 'new']);
            // 新增員工 (保存)
            Route::post('/staff/save', [StaffController::class, 'save']);
            // 員工列表
            Route::get('/staff/{state}', [StaffController::class, 'list']);
            Route::get('/staff/more/{state}/{page}', [StaffController::class, 'more']);
            // 編輯員工資料
            Route::get('/staff/{state}/{userId}', [StaffController::class, 'modify']);
            // 編輯員工資料 (凍結帳號)
            Route::post('/staff/lockUser', [StaffController::class, 'lockUser']);
            // 編輯員工資料 (解除凍結)
            Route::post('/staff/unlockUser', [StaffController::class, 'unlockUser']);
        });
    });

    /*
    |--------------------------------------------------------------------------
    | Home2 副畫面
    |--------------------------------------------------------------------------
    */
    Route::name('home2.')->group(function () {
        /** 副畫面 首頁 **/
        Route::get('/home2', [HomeController::class, 'home2'])->name('home2');
    });
});
