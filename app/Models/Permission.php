<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $table = 'permission';
    protected $primaryKey = 'permission_id';


    // 取得使用者的權限設定並陣列化
    public static function getUserPermission($user_id) {
        $data = array();

        $permission = Permission::where('user_id', $user_id)->get();

        foreach($permission as $row) {
            $data[$row['permission']] = ['permission' => $row->permission, 'action' => $row->action];
        }

        return $data;
    }

    // 更新使用者的權限設定
    public static function updateUserPermission($user_id, $roles) {
        // 刪除舊設定重新Insert
        $permission = Permission::where('user_id', $user_id)->delete();

        foreach((array)$roles as $value) {
            $permission = new Permission;
            $permission->user_id    = $user_id;
            $permission->permission = $value;
            $permission->action     = '';
            $permission->save();
        }
    }

    // 取得職位的權限設定並陣列化
    public static function getJobPermission($job_id) {
        $data = array();

        $permission = Permission::where('job_id', $job_id)->get();

        foreach($permission as $row) {
            $data[$row['permission']] = ['permission' => $row->permission, 'action' => $row->action];
        }

        return $data;
    }

    // 更新職位的權限設定
    public static function updateJobPermission($job_id, $roles) {
        // 刪除舊設定重新Insert
        $permission = Permission::where('job_id', $job_id)->delete();

        foreach((array)$roles as $value) {
            $permission = new Permission;
            $permission->job_id     = $job_id;
            $permission->permission = $value;
            $permission->action     = '';
            $permission->save();
        }
    }

}
