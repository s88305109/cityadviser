<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;
use App\Models\User;

class PermissionValid
{
    /**
     * 頁面權限與使用者狀態驗證
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  String  $role
     * @param  String  $action
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role = null, $action = null)
    {
        $user = Auth::user();

        $user->sign_out_time = date('Y-m-d H:i:s');
        $user->save();

        if (! empty($user))
            $company = Company::find($user->company_id);
        if (! empty($company))
            $principal = User::find($company->principal);
        
        // 若User狀態已被凍結 或 所屬公司已被凍結 或 所屬公司負責人帳號被凍結 就強制執行登出
        if ($user->status != 1 
            || (! empty($company) && $company->status != 1)
            || (! empty($principal) && $principal->status != 1)
            || ! empty($user->date_resignation)
        ) {
            Auth::logout();
            return redirect('/errors/locked');
        }

        // 若Route有傳入權限名稱則進行權限驗證
        if (! is_null($role))
            if (! Auth::user()->hasPermission($role, $action)) 
                return redirect('/errors/forbidden');

        return $next($request);
    }
}
