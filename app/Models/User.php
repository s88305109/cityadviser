<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'user';
    protected $primaryKey = 'user_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_number',
        'user_password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'user_password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    
    protected $casts = [
        //'updated_at' => 'datetime',
    ];

    // 驗證使用者密碼格式是否符合
    public static function passwordRuleVerify($passwdStr) 
    {
        if (! preg_match('/^[A-Za-z0-9]+$/', $passwdStr)) {
            $message = __('密碼只能輸入英文跟數字');
        } else if (! preg_match('/^((?=.*[0-9])(?=.*[a-z|A-Z]))^.*$/', $passwdStr)) {
            $message = __('密碼必須包含最少一個英文字母跟最少一個數字');
        } else if (strlen($passwdStr) < 8) {
            $message = __('密碼必須8個字以上');
        } else {
            $message = 'OK';
        }

        return $message;
    }

    // 取得公司有多少在職員工的人數
    public static function getCompanyCount($company_id) 
    {
        $count = User::where('company_id', $company_id)
            ->whereNull('user.date_resignation')
            ->count();

        return empty($count) ? 0 : $count;
    }

    // 頁面權限驗證 
    public function hasPermission($role, $action = null) 
    {
        // 檢查是否為超級管理員帳號
        if (Auth::user()->admin == 1)
            return true;

        // 檢查是否有設定個人客製化權限 若有則優先採用個人權限設定 否則採用職位通用權限
        $count = Permission::where('user_id', Auth::user()->user_id)->count();
        $field = ($count > 0) ? 'user_id' : 'job_id';

        // 檢查權限
        $permission = Permission::where($field, Auth::user()->$field)
            ->where('permission', $role)
            ->first();

        // 若有傳入行為控制權限 $action 則檢查是否有行為權限 (以JSON格式保存)
        if (! empty($permission)) {
            if (! is_null($action)) {
                $set = json_decode($permission->action, true);

                if (is_null($set) || ! in_array($action, $set))
                    return false;
            }

            return true;
        }

        return false;
    }

    // 取得員工列表 
    public static function getEmployees($state = 'on', $company_id, $hide = false, $orderRow, $direction = 'desc', $per = 20, $page = 1) 
    {
        $offset = ($page - 1) * $per;

        $company = Company::find($company_id);

        $users = User::join('company', 'company.company_id', '=', 'user.company_id')
            ->when($state == 'left', function ($query, $state) {
                return $query->whereNotNull('user.date_resignation');
            }, function ($query) {
                return $query->whereNull('user.date_resignation');
            })
            ->where('user.company_id', $company_id)
            ->where('user.user_number', '!=', 'user01')
            ->when($hide, function ($query, $hide) {
                return $query->where('user.user_id', '!=', $company->principal);
            }, function ($query) {
                return $query;
            })
            ->select('user.*', 'company.company_name')
            ->orderBy($orderRow, $direction)
            ->offset($offset)
            ->limit($per)
            ->get();

        return $users;
    }

}
