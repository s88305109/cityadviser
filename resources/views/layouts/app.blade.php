<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', '融鎰數位科技') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        /* Global */
        .no-background-image { background-image: none !important; }
        .no-underline { text-decoration:none; }
        .bg-light-red { background-color: hsl(0deg 100% 50% / 10%); }
        img.logo128 { 
            max-width: 128px; 
            padding: 0;
        }
        /* Input 內嵌圖示 */
        button.btn.radius {
            border-radius: 20px;
            font-size: 120%;
        }
        .inner-addon { position: relative; }
        .inner-addon i.bi {
            position: absolute;
            padding: 4px;
            font-size: 20px;
        }
        .inner-addon.reset-icon i.bi { 
            z-index: 10;
            display: none; 
            margin-right: .25em;
        }
        .left-addon i.bi  { left:  0px; }
        .right-addon i.bi { right: 0px; }
        .left-addon input { padding-left:  30px; }
        .right-addon input { padding-right: 30px; }
        .inner-addon i.bi.password-visible {
            z-index: 20;
            display: inline-block;
            margin-right: .25em;
        }

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
        .input-group-top > .form-control,
        .input-group-top > .form-select { border-radius: 0 0 0.25em 0.25em; }
        .input-group-top.inner-addon.reset-icon i.bi.bi-x-circle-fill { margin-top: -1.8em; }
        .job-set .btn { min-width: 106px; }
        .job-set .card-header { text-align: center; }
        .input-group-text, .gender-label { 
            display: inline-block;
            min-width: 88px; 
            text-align: center;
        }
        .more-loading {
            display: none;
            text-align: center;
            margin-top: 1em;
        }

        /* Loading Mask */
        .loading-mask {
            position: fixed;
            z-index: 9999;
            display: none;
            top: 0px;
            width: 100%;
            height: 100%;
            background-color: #111;
            opacity: 0.8;
        }
        .loading-mask .spinner-border {
            position: absolute;
            top: 50%;
            left: 50%;
            margin: -1rem 0 0 -1rem;
        }

        /* Float Navbar */
        .float-navbar {
            background-color: #EEE;
            border-top: 1px solid #CCC;;
        }

        /* Check List (Login) */
        ul.check-list li {
            padding: 0px;
            padding-left: 1.5em;
            background-color: transparent;
            border: 0px;
        }
        ul.check-list li i.bi {
            position: absolute;
            display: none;
            margin-left: -1.5em;
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
        .bottom-tabs {
            position: fixed;
            right: 0;
            bottom: 0;
            left: 0;
            z-index: 1030;
            background-color: #fff;
            margin-bottom: 54px;
        }
        .go-top,
        .go-bottom {
            position: fixed;
            z-index: 1040; 
            display: none;
            padding: 2px 8px;
            border-radius: 2em; 
        }
        .go-top,
        .go-bottom {
            right: 1em;
            top: 60%;
        }

        /* 組織管理 > 新增員工 & 編輯 */
        .employee-edit .job-set, 
        .employee-edit .staff-code-set { display: none; }
        .employee-edit .input-group-text  { min-width: 92px; }

        /* 組織管理 > 新增公司 & 編輯 */
        .company-edit .input-group-text,
        .staff-edit .input-group-text { min-width: 92px; }
        .company-edit .dropdown-menu {
            max-height: 18.5em;
            overflow: scroll;
        }
        .company-edit .dropdown-menu li { margin: .25em .75em; }
        .company-edit .ok-mark {
            float: right;
            margin-top: -2.5em;
            margin-right: .75em;
        }
        /* 組織管理 > 公司列表 */
        .company-list .badge.num-count{
            margin-top: -2.5em;
            margin-right: -0.8em;
            filter: opacity(1);
        }

        /* 組織管理 > 權限管理 & 客製化權限 */
        .role-edit .list-group-item .form-switch { padding-left: 3.5em; }
        .role-edit .list-group-item.grandson .form-switch { padding-left: 4.5em; }

        /* 個人資料 */
        .information-edit .password-change-text { 
            display: inline-block;
            min-width: 106px;
        }
        .information-edit #old_password, #confirm_password { background-image: none; }
        .information-edit .password-change-text.text-danger { border-color: #e3342f; }
        .container.list .list,
        .mb-6em { margin-bottom: 6rem; }

        /* 小秘書 */
        .secretary .toast { margin-bottom: 0.5rem; }
        .secretary .toast-header .rounded-circle { 
            margin-right: -0.375rem;
            margin-left: 0.75rem;
        }
        .secretary .toast .toast-body strong {  color: #dc3545; }
    </style>

    <script>
        var lastScrollTop = 0;

        $(document).ready(function () {
            {{-- 文字方塊叉叉圖示處理 --}}
            $(".inner-addon.reset-icon i.bi.bi-x-circle-fill").click(function() {
                isChanged = true;
                $(this).hide().parent().children("input, textarea").val("").focus().trigger("keyup");

                if ($(this).parent().children("textarea").attr("oninput") == "autoGrow(this);")
                    autoGrow($(this).parent().children("textarea")[0]);
            });

            $("textarea[oninput='autoGrow(this);']").each(function() {
                autoGrow(this);
            });

            $(".inner-addon.reset-icon input, .inner-addon.reset-icon textarea").on("keyup",function(e) {
                if ($(this).val() != "")
                    $(this).css("background-image", "none").parent().children("i.bi.bi-x-circle-fill").fadeIn();
                else
                    $(this).parent().children("i.bi.bi-x-circle-fill").hide();
            }).on("focus",function(e){
                if ($(this).val() != "")
                    $(this).css("background-image", "none").parent().children("i.bi").fadeIn();
                else
                    $(this).parent().children("i.bi.bi-x-circle-fill").hide();
            }).on("blur",function(e){ $(this).parent().children("i.bi.bi-x-circle-fill").fadeOut(); });

            {{-- 密碼切換顯示功能 --}}
            $("i.password-visible").click(function () {
                var obj = $(this).parent().find("input");

                if($(obj).attr("type") == "password") {
                    $("#user_password").attr("type", "text");
                    $("#show_password").val(1);
                } else {
                    $("#user_password").attr("type", "password");
                    $("#show_password").val(0);
                }
            });

            {{-- 捲動 GoTop & GoBottom 功能 --}}
            $(window).scroll(function(event){
                var st = $(this).scrollTop();

                if (st > lastScrollTop){
                    $(".go-top").hide();
                    $(".go-bottom").show();
                    setTimeout(function(){ $(".go-bottom").fadeOut(); }, 2000);
                } else {
                    $(".go-top").show();
                    $(".go-bottom").hide();
                    setTimeout(function(){ $(".go-top").fadeOut(); }, 2000);
                }

                lastScrollTop = st;
            });
        });

        {{-- 呼叫訊息提示視窗 --}}
        function showMessageModal(content) {
            $("#messageModal > .modal-dialog > .modal-content > .modal-body").html(content);
            $("#messageModal").modal("show");
        }

        {{-- 呼叫確認視窗 --}}
        function showConfirmModal(content, btn1Act = null) {
            $("#confirmModal .modal-body").html(content);

            if (btn1Act != null)
                $("#confirmModal button.btn-primary").attr("onclick", btn1Act);

            $("#confirmModal").modal("show");
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

        {{-- Textarea自動高度 --}}
        function autoGrow(element) {
            element.style.height = "5px";
            element.style.height = (element.scrollHeight + 2)+"px";
        }

        function refreshUnread() {
            $.ajax({
                type: "GET",
                url: "/unread",
                dataType: "text",
                success: function (response) {
                    if (response > 0)
                        $("span.unread").html(response).show();
                    else
                        $("span.unread").hide();
                },
                error: function (thrownError) {
                    showMessageModal(thrownError.responseJSON.message);
                }
            });
        }

        {{-- 需登入驗證的頁面才執行 --}}
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

            $(".go-top").bind("click", function () {
                $("html, body").animate({ scrollTop: 0 }, 200);
            });

            $(".go-bottom").bind("click", function () {
                $("html, body").animate({ scrollTop: $(document).height() }, 200);
            });

            setInterval(refreshUnread, 30000);
        });

        window.onbeforeunload = function () {
            if (isChanged & ! allowRedirect)              
                return "您尚未儲存修改的資料";
        }
        @endif
    </script>
</head>
<body>
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
                </div>
            </div>
        </nav>

        {{-- Fixed BottomBar --}}
        <nav class="navbar fixed-bottom float-navbar justify-content-center">
            <div class="col-md-6">
                <div class="row justify-content-evenly">
                    <div class="col-auto position-relative">
                        <a href="/secretary"><i class="bi bi-twitch fs-2"></i></a>
                        @if(App\Models\Secretary::getUnreadCount() > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger unread">{{ App\Models\Secretary::getUnreadCount() }}</span>
                        @else
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger unread"></span>
                        @endif
                    </div>
                    <div class="col-auto">
                        {!! App\Services\NavService::getSwitch() !!}
                    </div>
                    <div class="col-auto">
                        <a href="{{ App\Services\NavService::getHomeUrl() }}"><i class="bi bi-house-fill fs-2"></i></a>
                    </div>
                    <div class="col-auto">
                        <a href="{{ App\Services\NavService::getUpUrl() }}"><i class="bi bi-tags-fill fs-2"></i></a>
                    </div>
                </div>
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
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">確認</button>
                </div>
            </div>
        </div>
    </div>

    {{-- 確認視窗 --}}
    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body text-center"></div>
                <div class="modal-footer justify-content-center">
                    <button class="btn btn-primary untrigger" type="button">　是　</button>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">　否　</button>
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

    <div class="go-top btn-secondary"><i class="bi bi-chevron-bar-up fs-3"></i></div>
    <div class="go-bottom btn-secondary"><i class="bi bi-chevron-bar-down fs-3"></i></div>
</body>
</html>
