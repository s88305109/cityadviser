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
    public static function getUserPermission($user_id) 
    {
        $data = array();

        $permission = Permission::where('user_id', $user_id)->get();

        foreach($permission as $row)
            $data[$row->permission] = ['permission' => $row->permission, 'action' => $row->action];

        return $data;
    }

    // 更新使用者的權限設定
    public static function updateUserPermission($user_id, $roles) 
    {
        $oldData = self::getUserPermission($user_id);
        $job     = Job::find(User::find($user_id)->job_id);

        if (! empty($roles)) {
            foreach($roles as $value) {
                // 新增權限
                if (empty($oldData) || ! isset($oldData[$value])) {
                    $permission = new Permission;
                    $permission->user_id    = $user_id;
                    $permission->permission = $value;
                    $permission->action     = '';
                    $permission->save();

                    // 若首次新增個人客製化權限 職位通用權限內已有的項目不做事件通知
                    if (empty($oldData) && Permission::where('job_id', $job->job_id)->where('permission', $value)->count() > 0)
                        continue;

                    $role      = Role::where('role', $value)->where('type', $job->type)->first();
                    $parameter = array();
                    $event     = 'roleAdd';

                    if ($role->parent > 0) {
                        $event = 'roleAdd2';
                        $parent = Role::find($role->parent);
                        $parameter[] = $parent->title;
                    }

                    $parameter[] = $role->title;
                    $parameter   = json_encode($parameter, JSON_UNESCAPED_UNICODE);

                    Secretary::createEvent($user_id, $event, $parameter);
                }
            }
        }

        if (! empty($oldData)) {
            foreach($oldData as $key => $row) {
                // 移除權限
                if (empty($roles) || ! in_array($key, $roles)) {
                    Permission::where('user_id', $user_id)->where('permission', $key)->delete();

                    // 若移除個人客製化權限後 職位通用權限內已有的項目不做事件通知
                    if (empty($roles) && Permission::where('job_id', $job->job_id)->where('permission', $key)->count() > 0)
                        continue;

                    $role      = Role::where('role', $key)->where('type', $job->type)->first();
                    $parameter = array();
                    $event     = 'roleDel';

                    if ($role->parent > 0) {
                        $event = 'roleDel2';
                        $parent = Role::find($role->parent);
                        $parameter[] = $parent->title;
                    }

                    $parameter[] = $role->title;
                    $parameter   = json_encode($parameter, JSON_UNESCAPED_UNICODE);

                    Secretary::createEvent($user_id, $event, $parameter);
                }
            }
        }
    }

    // 取得職位的權限設定並陣列化
    public static function getJobPermission($job_id) 
    {
        $data = array();

        $permission = Permission::where('job_id', $job_id)->get();

        foreach($permission as $row)
            $data[$row['permission']] = ['permission' => $row->permission, 'action' => $row->action];

        return $data;
    }

    // 更新職位的權限設定
    public static function updateJobPermission($job_id, $roles) 
    {
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
