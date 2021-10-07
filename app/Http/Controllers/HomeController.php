<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Secretary;

class HomeController extends Controller
{
    // 主畫面
    public function index()
    {
        // 選單設定
        $sysList = [
            'case'         => ['title' => '報件管理', 'icon' => '<i class="bi bi-briefcase"></i>'],
            'review'       => ['title' => '報件審查', 'icon' => '<i class="bi bi-zoom-in"></i>'],
            'organization' => ['title' => '組織管理', 'icon' => '<i class="bi bi-diagram-3"></i>'],
            'staff'        => ['title' => '員工管理', 'icon' => '<i class="bi bi-person-circle"></i>'],
        ];

        // 權限檢查
        foreach($sysList as $key => $rows) {
            if (! Auth::user()->hasPermission($key))
                unset($sysList[$key]);
        }

        session(['pageBlock' => '/home']);

        return view('home.home', ['sysList' => $sysList, 'pageBlock' => 'home']);
    }

    // 副畫面
    public function home2()
    {
        $sysList = [
            'working' => ['title' => '副畫面', 'icon' => '<i class="bi bi-cone"></i>'],
        ];

        session(['pageBlock' => '/home2']);

        return view('home.home', ['sysList' => $sysList, 'pageBlock' => 'home2']);
    }

    // 小秘書事件未讀數量
    public function unread()
    {
        return response(Secretary::getUnreadCount());
    }

}
