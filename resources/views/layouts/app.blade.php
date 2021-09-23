<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', '融鎰數位科技') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
    .no-underline { text-decoration:none; }
    img.logo128 { 
        max-width: 128px; 
        padding: 0;
    }
    .bottomNavUl {
        width: 100%;
        margin: 2px 0;
        padding: 0 1em;
    }
    .bottomNavUl li {
        display: inline-block;
        margin-right: 8px;
        height: 32px;
        line-height: 32px;
        vertical-align: middle;
    }
    .bottomNavUl li:nth-child(2) { margin-top: -6px; }
    .bottomNavUl li:last-child { margin-right: 0; }
    /* Input 內嵌圖示 */
    button.btn.radius {
        border-radius: 20px;
        font-size: 120%;
    }
    .inner-addon { position: relative; }
    .inner-addon i.bi {
        font-size: 20px;
        position: absolute;
        padding: 4px;
    }
    .inner-addon.reset-icon i.bi { 
        display: none; 
        z-index: 10;
        margin-right: .75em;;
    }
    .left-addon i.bi  { left:  0px; }
    .right-addon i.bi { right: 0px; }
    .left-addon input { padding-left:  30px; }
    .right-addon input { padding-right: 30px; }

    .inner-addon i.bi.password-visible {
        z-index: 999;
        display: inline-block;
        margin-right: 4px;
    }

    /* Loading Mask */
    .loading-mask {
        position: fixed;
        z-index: 9999;
        background-color: #111;
        width: 100%;
        height: 100%;
        top: 0px;
        opacity: 0.8;
        display: none;
    }
    .loading-mask .spinner-border {
        margin: -1rem 0 0 -1rem;
        position: absolute;
        top: 50%;
        left: 50%;
    }

    /* Float Navbar */
    .float-navbar {
        background-color: #EEE;
        border-top: 1px solid #CCC;;
    }
    .float-navbar .back-icon { font-size: 24px; }
    .navbar-header { font-size: 18px; }

    .home-link {
        padding: 6px 8px 2px 8px;
        color: #FFF;
    }

    ul.check-list li {
        background-color: transparent;
        border: 0px;
        padding: 0px;
        padding-left: 1.2em;
    }
    ul.check-list li i.bi {
        position: absolute;
        margin-left: -1.2em;
        display: none;
    }

    /* Navbar 搜尋元件 */
    #search_str.is-invalid { background-image: none; }
    #search_str.is-invalid::placeholder { color: #e3342f; }

    /* Shake Effect */
    .obj-shake {
        animation: shake 0.5s;
        animation-iteration-count: infinite;
    }

    @keyframes shake {
        0% { transform: translate(1px, 1px) rotate(0deg); }
        10% { transform: translate(-1px, -2px) rotate(-1deg); }
        20% { transform: translate(-3px, 0px) rotate(1deg); }
        30% { transform: translate(3px, 2px) rotate(0deg); }
        40% { transform: translate(1px, -1px) rotate(1deg); }
        50% { transform: translate(-1px, 2px) rotate(-1deg); }
        60% { transform: translate(-3px, 1px) rotate(0deg); }
        70% { transform: translate(3px, 1px) rotate(-1deg); }
        80% { transform: translate(-1px, -1px) rotate(1deg); }
        90% { transform: translate(1px, 2px) rotate(0deg); }
        100% { transform: translate(1px, -2px) rotate(-1deg); }
    }

    /*  主畫面 > 功能頁選單 */
    .block-inner-page { font-size: 1.5em; }
    .block-inner-page .card-title { font-size: 2.5em; }
    .block-inner-page .two-column { width: calc(50% - 7px); }

    /* Form Input Group */
    .input-group-text {
        border-bottom-right-radius: 0;
        border-top-right-radius: 0;
    }
    .input-group-top .input-group, .input-group-top .input-group-text { 
        width: 100%; 
        border-bottom: 0;
    }
    .input-group-top .input-group-text { border-radius: 0.25em 0.25em 0 0; }
    .input-group-top > input.form-control,
    .input-group-top > textarea.form-control { border-radius: 0 0 0.25em 0.25em; }
    .input-group-top.inner-addon.reset-icon i.bi { margin-top: -1.8em; }
    .job-set .btn { min-width: 88px; }
    .job-set .card-header { text-align: center; }
    .input-group-text, .gender-label { 
        min-width: 88px; 
        display: inline-block;
        text-align: center;
    }
    .bottom-tabs {
        position: fixed;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: 1030;
        background-color: #fff;
        margin-bottom: 54px;
    }
    </style>

    <script>
        $(document).ready(function () {
            {{-- 文字方塊叉叉圖示處理 --}}
            $(".inner-addon.reset-icon i.bi").click(function() {
                $(this).hide().parent().children("input, textarea").val("").focus().trigger("keyup");
            });

            $(".inner-addon.reset-icon input, .inner-addon.reset-icon textarea").on("keyup",function(e) {
                if ($(this).val() != "") {
                    $(this).parent().children("i.bi").fadeIn();
                    $(this).css("background-image", "none");
                } else {
                    $(this).parent().children("i.bi").hide();
                }
            }).on("focus",function(e){
                if ($(this).val() != "") {
                    $(this).parent().children("i.bi").fadeIn();
                    $(this).css("background-image", "none");
                } else {
                    $(this).parent().children("i.bi").hide();
                }
            }).on("blur",function(e){ $(this).parent().children("i.bi").hide(); });
        });

        {{-- 訊息提示視窗Function --}}
        function showMessageModal(content) {
            $("#messageModal > .modal-dialog > .modal-content > .modal-body").html(content);
            $("#messageModal").modal("show");
        }

        function hideMessageModal() {
            $("#messageModal").modal("hide");
        }

        {{-- Loading Mask Function --}}
        function showLoadingMask() {
            $(".loading-mask").fadeIn(100);
        }
        function hideLoadingMask() {
            $(".loading-mask").fadeOut(100);
        }

        {{-- 物件抖動效果 --}}
        function objectShake(obj) {
            $(obj).addClass("obj-shake");
            setTimeout(function(){ $(obj).removeClass("obj-shake"); }, 500);
        }

        {{-- 全站搜尋 --}}
        function searchContent() {
            if ($("#search_str").val().length < 2) {
                $("#search_str").val("").addClass("is-invalid").attr("placeholder", "至少輸入2個字");
                return false;
            }
        }

        function getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
        }

        @if (substr(Route::currentRouteName(), 0, 5) == 'auth.')
        var isChanged = false;
        var allowRedirect = false;

        $(document).ready(function () {
            $("input, textarea, select").not(".skip-change-validate input").not(".skip-change-validate").change(function () {
                isChanged = true;
            });
            $(".untrigger").bind("click", function () {
                isChanged = false;
            }).bind("change", function () {
                isChanged = false;
            });
        });

        window.onbeforeunload = function () {
            if (isChanged & ! allowRedirect) {                
                return "您尚未儲存修改的資料";
            }
        }
        @endif
    </script>
</head>
<body>
<?php 
// 回到首頁的連結
$navlink1 = (session('pageBlock') !== null) ? session('pageBlock') : '/home';

// 取得系統結構上一層的連結
$navlink2 = '/';
for($i = 1; $i <= count(Request::segments()); $i++)
    if($i < count(Request::segments()) & $i > 0)
        $navlink2 .= ($navlink2 == '/') ? Request::segment($i) : '/' . Request::segment($i);

if ($navlink2 == '/')
    $navlink2 = $navlink1;
?>
    <div id="app">
        @if (substr(Route::currentRouteName(), 0, 5) == 'auth.')
        {{-- Fixed HeaderBar --}}
        <nav class="navbar navbar-fixed-top">
            <div class="container px-0 col-md-6">
                <div class="w-100 fs-4 px-3">
                    <a class="no-underline" href="/user">
                        <i class="bi bi-person-fill"></i> 
                        <span>{{ Auth::user()->name }}</span>
                    </a>

                    <div class="float-end"><i class="bi bi-twitch"></i></div>
                </div>
            </div>
        </nav>

        {{-- Fixed BottomBar --}}
        <nav class="navbar fixed-bottom navbar-light float-navbar justify-content-center">
            <div class="col-md-6">
                <ul class="bottomNavUl">
                    <li>
                        @if (Route::currentRouteName() == 'auth.home2')
                        <a class="bg-primary rounded home-link" href="/home"><i class="bi bi-back"></i></a>
                        @else
                        <a class="bg-dark rounded home-link" href="/home2"><i class="bi bi-list-ul"></i></a>
                        @endif
                    </li>
                    <li>
                        <a href="{{ $navlink1 }}"><img src="/images/logo-32.png"></a>
                    </li>
                    <li>
                        <a href="{{ $navlink2 }}"><i class="bi bi-tags back-icon"></i></a>
                    </li>
                    <li class="float-end">
                        <div class="inner-addon right-addon">
                            <form class="search-form">
                                <i class="bi bi-search" onclick="searchContent();"></i>
                                <input class="form-control skip-change-validate" type="search" id="search_str" name="search_str" placeholder="{{ __('請輸入關鍵字') }}">
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        @endif
    
        <main id="main" class="py-2">
            @yield('content')
        </main>
    </div>

    {{-- 訊息提示視窗 --}}
    <div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body text-danger"></div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-primary" onclick="hideMessageModal();">確認</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Loading 遮罩 --}}
    <div class="loading-mask justify-content-center">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</body>
</html>
