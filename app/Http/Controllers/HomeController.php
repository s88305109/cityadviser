<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $sysList = [
            'sys01' => ['title' => '客戶管理', 'icon' => '<i class="bi bi-people-fill"></i>'],
            'sys02' => ['title' => '報件管理', 'icon' => '<i class="bi bi-file-text-fill"></i>'],
            'sys03' => ['title' => '業務管理', 'icon' => '<i class="bi bi-file-person"></i>'],
            'sys04' => ['title' => '情境參考', 'icon' => '<i class="bi bi-lightbulb"></i>'],
        ];

        return view('home.home', ['sysList' => $sysList]);
    }

    public function home2()
    {
        $sysList = [
            'sys01' => ['title' => '副畫面一', 'icon' => '<i class="bi bi-people-fill"></i>'],
            'sys02' => ['title' => '副畫面二', 'icon' => '<i class="bi bi-file-text-fill"></i>'],
            'sys03' => ['title' => '副畫面三', 'icon' => '<i class="bi bi-file-person"></i>'],
            'sys04' => ['title' => '副畫面四', 'icon' => '<i class="bi bi-lightbulb"></i>'],
        ];

        return view('home.home', ['sysList' => $sysList]);
    }
}
