<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

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
    public static function passwordRuleVerify($passwdStr) {
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

}
