<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', '融鎰數位科技') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
    /* Input 內嵌圖示 */
    button.btn.radius {
        border-radius:20px;
        font-size: 120%;
    }

    .inner-addon { 
        position: relative; 
    }
    .inner-addon i.bi {
        font-size: 20px;
        position: absolute;
        padding: 4px;
    }
    .inner-addon.reset-icon i.bi {
        display: none;
    }
    .left-addon i.bi  { left:  0px;}
    .right-addon i.bi { right: 0px;}
    .left-addon input  { padding-left:  30px; }
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
    .float-navbar .back-icon {
        font-size: 24px;
    }

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
    </style>

    <script type="text/javascript">
        $(document).ready(function () {
            {{-- 文字方塊叉叉圖示處理 --}}
            $(".inner-addon.reset-icon i.bi").click(function() {
                $(this).hide().parent().children("input").val("").focus();
            });

            $(".inner-addon.reset-icon input").on('keyup',function(e) {
                if ($(this).val() != "") {
                    $(this).parent().children("i.bi").fadeIn();
                    $(this).css("background-image", "none");
                } else {
                    $(this).parent().children("i.bi").hide();
                }
            });
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

        function objectShake(obj) {
            $(obj).addClass("obj-shake");
            setTimeout(function(){ $(obj).removeClass("obj-shake"); }, 500);
        }
    </script>
</head>
<body>
    <div id="app">
        @if (! in_array(Route::currentRouteName(), array('login', 'error')))
            {{-- Fixed Headerbar --}}
            <nav class="navbar navbar-default navbar-fixed-top">
                <div class="container">
                    <div class="navbar-header row">
                        <i class="bi bi-person-fill"></i> 
                        <span>{{ Auth::user()->user_number }}</span>
                    </div>
                </div>
            </nav>

            {{-- Fixed Bottom Navbar --}}
            <nav class="navbar fixed-bottom navbar-expand navbar-light float-navbar">
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item form-inline">
                            <button class="btn border btn-dark navbar-dark px-2" type="button">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                        </li>
                        <li class="nav-item form-inline">
                            <a class="nav-link" href="/"><img src="/images/logo-32.png"></a>
                        </li>
                        <li class="nav-item form-inline">
                            <a class="nav-link" href="@isset($levelRoot) {{ $levelRoot }} @else / @endisset"><i class="bi bi-tags back-icon"></i></a>
                        </li>
                        <li class="nav-item form-inline">
                            <div class="inner-addon right-addon">
                                <i class="bi bi-search"></i>
                                <input class="form-control" type="search" placeholder="{{ __('請輸入關鍵字') }}">
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
            <span class="sr-only">Loading...</span>
        </div>
    </div>
</body>
</html>
