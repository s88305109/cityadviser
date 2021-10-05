@extends('layouts.app')

@section('content')

<script>
    $(document).ready(function () {
        $("#reload").click(function () {
            refreshCaptcha();
        });

        $("#show_password").click(function () {
            if($(this).is(":checked")) {
                $("#user_password").attr("type", "text");
            } else {
                $("#user_password").attr("type", "password");
            }
        });

        $("#user_number, #captcha").on("keyup",function(e) {
            $("#run").removeClass("btn-danger");

            if ($(this).val() != "") {
                $("#run").prop("disabled", false);
            } else {
                $("#run").prop("disabled", true);
            }
        });

        $("#user_password").on("keyup",function(e) {
            if ($(this).val().length >= 8 && $(this).val().length <= 25) 
                $("ul.check-list li i.bi:eq(0)").show();
            else
                $("ul.check-list li i.bi:eq(0)").hide();

            if (/^((?=.*[0-9])(?=.*[a-z|A-Z])(?!.*[^a-z|A-Z|0-9]))^.*$/.test($(this).val()))
                $("ul.check-list li i.bi:eq(1)").show();
            else
                $("ul.check-list li i.bi:eq(1)").hide();

            if (/^(?=.*[a-z|A-Z])^.*$/.test($(this).val()))
                $("ul.check-list li i.bi:eq(2)").show();
            else
                $("ul.check-list li i.bi:eq(2)").hide();

            if (/^[A-Za-z0-9]+$/.test($(this).val()))
                $("ul.check-list li i.bi:eq(3)").show();
            else
                $("ul.check-list li i.bi:eq(3)").hide();

            if ($("ul.check-list li i.bi:visible").length == 4) {
                $("#run").prop("disabled", false);
                $("#run").removeClass("btn-danger");
            } else {
                $("#run").prop("disabled", true);
                $("#run").addClass("btn-danger");
            }
        });

        $("#run").click(function () {
            if($(".step1").is(":visible")) {
                if ($("#user_number").val() == "") {
                    $("#user_number").addClass("is-invalid");
                    $("#user_number_label").html("請輸入帳號").addClass("text-danger");
                    objectShake($("#user_number"));
                    return false;
                }

                checkUsername();
            } else if($(".step2").is(":visible")) {
                if ($("#user_password").val() == "") {
                    $("#user_password").addClass("is-invalid");
                    $("#user_password_label").html("請輸入密碼").addClass("text-danger");
                    objectShake($("#user_password"));
                    return false;
                }

                checkPassword();
            } else if($(".step3").is(":visible")) {
                if ($("#captcha").val() == "") {
                    $("#captcha").addClass("is-invalid");
                    $("#captcha_label").html("請輸入驗證碼").addClass("text-danger");
                    objectShake($("#captcha"));
                    return false;
                }
                showLoadingMask();
                $("form.login-form").submit();
            }
        });

        $("#prev").click(function () {
            $("#user_number, #user_password").val("");
            $(".step2, .step3, #prev").addClass("d-none");
            $(".step1").removeClass("d-none");
            $("#user_number, #user_password").removeClass("is-invalid");
            $("#run").removeClass("btn-danger");
            $("#user_number").parent().find("span.invalid-feedback > strong").remove();
            $("#user_password").parent().find("span.invalid-feedback > strong").remove();
            $("ul.check-list li i.bi").hide();
        });

        $("#user_number, #user_password, #captcha").on("keypress",function(e) {
            if(e.which == 13) {
                $("#run").trigger("click");
            }
        });

        @error('user_password')
        $(".step1, .step3").addClass("d-none");
        $(".step2").removeClass("d-none");
        $("#user_password").focus();
        objectShake($("#user_password"));
        @enderror

        @error('captcha')
        $(".step1, .step2").addClass("d-none");
        $(".step3").removeClass("d-none");
        $("#captcha").focus();
        objectShake($("#captcha"));
        @enderror

        @error('user_lock')
        showMessageModal("{{ $message }}");
        @enderror
    });

    function checkUsername() {
        $.ajax({
            type: "POST",
            url: "/check",
            data: $(".login-form").serialize(),
            dataType: "json",
            success: function (response) {
                if ($("#user_password").val() == "") {
                    $("#run").prop("disabled", true);
                    $("#run").addClass("btn-danger");
                }

                $(".step1, .step3").addClass("d-none");
                $(".step2, #prev").removeClass("d-none");
                $("#user_password").focus();
            },
            error: function (thrownError) {
                $("#user_number").addClass("is-invalid");
                $("#run").addClass("btn-danger");

                if (thrownError.status == "419") {
                    $("#user_number").parent().find("span.invalid-feedback").remove();
                    showMessageModal("{{ __('頁面閒置過久請重新整理網頁') }}");
                } else if (thrownError.responseJSON.code == "40003") {
                    $("#user_number").parent().find("span.invalid-feedback").remove();
                    showMessageModal(thrownError.responseJSON.message);
                } else if ($("#user_number").parent().find("span.invalid-feedback").length == 0) {
                    $("#user_number").parent().append('<span class="invalid-feedback" role="alert"><strong>' + thrownError.responseJSON.message + '</strong></span>');
                    objectShake($("#user_number"));
                } else {
                    $("#user_number").parent().find("span.invalid-feedback > strong").html(thrownError.responseJSON.message);
                    objectShake($("#user_number"));
                }
            }
        });
    }

    function checkPassword() {
        $.ajax({
            type: "POST",
            url: "/check2",
            data: $(".login-form").serialize(),
            dataType: "json",
            success: function (response) {
                $("#run").prop("disabled", true);
                $(".step1, .step2, #prev").addClass("d-none");
                $(".step3").removeClass("d-none");
                $("#captcha").focus();
            },
            error: function (thrownError) {
                $("#user_password").addClass("is-invalid");
                $("#run").addClass("btn-danger");

                if (thrownError.status == "419") {
                    $("#user_number").parent().find("span.invalid-feedback").remove();
                    showMessageModal("{{ __('頁面閒置過久請重新整理網頁') }}");
                } else if (thrownError.responseJSON.code == "40003") {
                    $("#user_password").parent().find("span.invalid-feedback").remove();
                    showMessageModal(thrownError.responseJSON.message);
                } else if ($("#user_password").parent().find("span.invalid-feedback").length == 0) {
                    $("#user_password").parent().append('<span class="invalid-feedback" role="alert"><strong>' + thrownError.responseJSON.message + '</strong></span>');
                    objectShake($("#user_password"));
                } else {
                    $("#user_password").parent().find("span.invalid-feedback > strong").html(thrownError.responseJSON.message);
                    objectShake($("#user_password"));
                }
            }
        });
    }

    function refreshCaptcha() {
        $.get("/reload-captcha").done(function(data){
            $(".captcha span").html(data.captcha);
            $("#captcha").val("");
        });
    }
</script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-3">
            <div class="row justify-content-center mt-2">
                <img class="logo128" src="/images/logo-128.png">
            </div>
            <h1 class="text-center mt-2">{{ config('app.name', '融鎰數位科技') }}</h1>

            <div class="card-body">
                <form class="login-form" method="POST" action="/login" novalidate>
                    @csrf

                    <div class="form-group step1">
                        <label class="col-form-label text-md-right" id="user_number_label" for="user_number">{{ __('請輸入帳號') }}</label>

                        <div class="inner-addon right-addon reset-icon">
                            <i class="bi bi-x-circle-fill text-danger"></i>
                            <input class="form-control @error('user_number') is-invalid @enderror" id="user_number" name="user_number" type="text" value="{{ old('user_number') }}" required autofocus>

                            @error('user_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group step2 d-none">
                        <label class="col-form-label text-md-right" id="user_password_label" for="user_password">{{ __('請輸入密碼') }}</label>

                        <div class="inner-addon right-addon reset-icon">
                            <i class="bi bi-x-circle-fill text-danger"></i>
                            <input class="form-control @error('user_password') is-invalid obj-shake @enderror" id="user_password" name="user_password" type="password" value="{{ old('user_password') }}" required autocomplete="current-password" maxlength="25">

                            @error('user_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mt-2">
                            <div class="form-check form-check-inline">
                                <label class="form-check-label" for="show_password"><input class="form-check-input" id="show_password" type="checkbox">{{ __('顯示密碼') }}</label>
                            </div>
                        </div>

                        <div>
                            <ul class="list-group check-list">
                                <li class="list-group-item"><i class="bi bi-check-circle-fill text-success"></i> 密碼長度8-25個字元</li>
                                <li class="list-group-item"><i class="bi bi-check-circle-fill text-success"></i> 英文與數字的組合</li>
                                <li class="list-group-item"><i class="bi bi-check-circle-fill text-success"></i> 包含一個大小或小寫字母</li>
                                <li class="list-group-item"><i class="bi bi-check-circle-fill text-success"></i> 沒有使用符號</li>
                            </ul>
                        </div>
                    </div>

                    <div class="form-group step3 d-none">
                        <label class="col-form-label text-md-right" id="captcha_label" for="captcha">{{ __('請輸入驗證碼') }}</label>

                        <div>
                            <input class="form-control @error('captcha') is-invalid @enderror" id="captcha" name="captcha" type="text" required autocomplete="off">

                            @error('captcha')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="captcha">
                            <span>{!! captcha_img() !!}</span>
                            <button class="btn btn-primary reload" id="reload" type="button">
                                &#x21bb;
                            </button>
                        </div>
                    </div>

                    <div class="form-group mb-0 justify-content-center">
                        <button class="btn btn-primary w-100 mt-3 px-5 @error('captcha') btn-danger @enderror" id="run" type="button" {{ old('user_number') ? ''  : 'disabled' }}>
                            {{ __('繼續') }}
                        </button>

                        <button class="btn btn-secondary w-100 mt-3 px-5 d-none" id="prev" type="button">{{ __('上一步') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
