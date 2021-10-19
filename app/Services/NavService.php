<?php

namespace App\Services;

use Route;
use Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;

class NavService 
{
    // 主畫面 & 副畫面 切換
    public static function getSwitch() 
    {
        if (session('pageBlock') !== null && session('pageBlock') == '/home2')
            return '<a href="/home"><i class="bi bi-back fs-2"></i></a>';
        else if (empty(session('pageBlock') ) && substr(Route::currentRouteName(), 0, 11) == 'auth.home2.')
            return '<a href="/home"><i class="bi bi-back fs-2"></i></a>';
        else
            return '<a href="/home2"><i class="bi bi-front fs-2"></i></a>';        
    }

    // 回到首頁
    public static function getHomeUrl() 
    {
        $link = (session('pageBlock') !== null) ? session('pageBlock') : '/home';
        
        return $link;
    }

    // 回上一層
    public static function getUpUrl() 
    {
        // 組織管理 層次導航
        if (Route::currentRouteName() == 'auth.home.organization.employee') {
            if (Auth::user()->hasPermission('employee') & ! Auth::user()->hasPermission('company')) 
                return '/home';
        } else if (Route::currentRouteName() == 'auth.home.organization.company') {
            if (! Auth::user()->hasPermission('employee') & Auth::user()->hasPermission('company')) 
                return '/home';
        } else if (Route::currentRouteName() == 'auth.home.organization.company.search') {
            // 組織管理 > 公司管理 > 關鍵字搜尋 
            $areas = Company::getAreas();
            $first = empty(reset($areas)) ? '南部' : reset($areas);
            return '/organization/company/'.$first;
        } else if (Route::currentRouteName() == 'auth.home.organization.company.search.edit') {
            // 組織管理 > 公司管理 > 關鍵字搜尋 > 編輯公司
            return '/organization/company/search/'.request()->keyword;
        } else if (Route::currentRouteName() == 'auth.home.organization.company.search.people') {
            // 組織管理 > 公司管理 > 關鍵字搜尋 > 員工列表
            return '/organization/company/search/'.request()->keyword;
        }

        $link = '/';

        for($i = 1; $i <= count(Request::segments()); $i++)
            if($i < count(Request::segments()) & $i > 0)
                $link .= ($link == '/') ? Request::segment($i) : '/' . Request::segment($i);

            if ($link == '/')
                $link = self::getHomeUrl();
        
        return $link;
    }

}
