<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    // 主畫面
    public function index()
    {
        $sysList = [
            'sys01' => ['title' => '客戶管理', 'icon' => '<i class="bi bi-people-fill"></i>'],
            'sys02' => ['title' => '報件管理', 'icon' => '<i class="bi bi-file-text-fill"></i>'],
            'sys03' => ['title' => '業務管理', 'icon' => '<i class="bi bi-file-person"></i>'],
            'organization' => ['title' => '組織管理', 'icon' => '<i class="bi bi-diagram-3"></i>'],
        ];

        session(['pageBlock' => '/home']);

        return view('home.home', ['sysList' => $sysList, 'pageBlock' => 'home']);
    }

    // 副畫面
    public function home2()
    {
        $sysList = [
            'sys01' => ['title' => '副畫面一', 'icon' => '<i class="bi bi-people-fill"></i>'],
            'sys02' => ['title' => '副畫面二', 'icon' => '<i class="bi bi-file-text-fill"></i>'],
            'sys03' => ['title' => '副畫面三', 'icon' => '<i class="bi bi-file-person"></i>'],
        ];

        session(['pageBlock' => '/home2']);

        return view('home.home', ['sysList' => $sysList, 'pageBlock' => 'home2']);
    }
}
