<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionValid
{
    /**
     * 頁面權限與使用者狀態驗證
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role = null, $action = null)
    {
        // 若User狀態已被凍結就強制執行登出
        if (Auth::user()->status != 1) {
            Auth::logout();
            return redirect('/errors/unauthorized');
        }

        // 若Route有傳入權限名稱 且登入帳號管理員權限未啟用則進行權限驗證
        if (! is_null($role) && Auth::user()->admin != 1)
            if (! Auth::user()->hasPermission($role, $action)) 
                return redirect('/errors/forbidden');

        return $next($request);
    }
}
