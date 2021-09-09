@extends('layouts.app')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<script type="text/javascript">
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content")
            }
        });

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

        $("#user_number, #user_password, #captcha").on('keyup',function(e) {
            if ($(this).val() != "") {
                $("#run").prop("disabled", false);
            } else {
                $("#run").prop("disabled", true);
            }
        });

        $("#run").click(function () {
            if($(".step1").is(":visible")) {
                if ($("#user_number").val() == "") {
                    $("#user_number").addClass("is-invalid");
                    $("#user_number_label").html("請輸入帳號").addClass("text-danger");
                    return false;
                }

                checkUsername();
            } else if($(".step2").is(":visible")) {
                if ($("#user_password").val() == "") {
                    $("#user_password").addClass("is-invalid");
                    $("#user_password_label").html("請輸入密碼").addClass("text-danger");
                    return false;
                }

                checkPassword();
                /*
                $("#run").prop("disabled", true);
                $(".step1, .step2").addClass("d-none");
                $(".step3").removeClass("d-none");
                $("#captcha").focus();
                */
            } else if($(".step3").is(":visible")) {
                if ($("#captcha").val() == "") {
                    $("#captcha").addClass("is-invalid");
                    $("#captcha_label").html("請輸入驗證碼").addClass("text-danger");
                    return false;
                }
                showLoadingMask();
                $("form.login-form").submit();
            }
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
        @enderror

        @error('captcha')
        $(".step1, .step2").addClass("d-none");
        $(".step3").removeClass("d-none");
        $("#captcha").focus();
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
                if ($("#user_password").val() == "") 
                    $("#run").prop("disabled", true);

                $(".step1, .step3").addClass("d-none");
                $(".step2").removeClass("d-none");
                $("#user_password").focus();
            },
            error: function (thrownError) {
                $("#user_number").addClass("is-invalid");

                if (thrownError.responseJSON.code == "40003") {
                    $("#user_number").parent().find("span.invalid-feedback").remove();
                    showMessageModal(thrownError.responseJSON.message);
                } else if ($("#user_number").parent().find("span.invalid-feedback").length == 0) {
                    $("#user_number").parent().append('<span class="invalid-feedback" role="alert"><strong>' + thrownError.responseJSON.message + '</strong></span>');
                } else {
                    $("#user_number").parent().find("span.invalid-feedback > strong").html(thrownError.responseJSON.message);
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
                $(".step1, .step2").addClass("d-none");
                $(".step3").removeClass("d-none");
                $("#captcha").focus();
            },
            error: function (thrownError) {
                $("#user_password").addClass("is-invalid");

                if (thrownError.responseJSON.code == "40003") {
                    $("#user_password").parent().find("span.invalid-feedback").remove();
                    showMessageModal(thrownError.responseJSON.message);
                } else if ($("#user_password").parent().find("span.invalid-feedback").length == 0) {
                    $("#user_password").parent().append('<span class="invalid-feedback" role="alert"><strong>' + thrownError.responseJSON.message + '</strong></span>');
                } else {
                    $("#user_password").parent().find("span.invalid-feedback > strong").html(thrownError.responseJSON.message);
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
        <div class="col-md-8">
            <div class="row justify-content-center mt-2">
                <img src="/images/logo-128.png">
            </div>
            <h1 class="text-center mt-1">{{ config('app.name', '融鎰數位科技') }}</h1>

            <div class="card-body">
                <form class="login-form" method="POST" action="/login" novalidate>
                    @csrf

                    <div class="form-group row step1">
                        <label id="user_number_label" for="user_number" class="col-md-4 col-form-label text-md-right">請輸入帳號</label>

                        <div class="col-md-6">
                            <div class="inner-addon right-addon reset-icon">
                                <i class="bi bi-x-circle-fill text-danger"></i>
                                <input type="text" class="form-control @error('user_number') is-invalid @enderror" id="user_number" name="user_number" value="{{ old('user_number') }}" required autofocus>

                                @error('user_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group row step2 d-none">
                        <label id="user_password_label" for="user_password" class="col-md-4 col-form-label text-md-right">請輸入密碼</label>

                        <div class="col-md-6">
                            <div class="inner-addon right-addon reset-icon">
                                <i class="bi bi-x-circle-fill text-danger"></i>
                                <input type="password" class="form-control @error('user_password') is-invalid @enderror" id="user_password" name="user_password" value="{{ old('user_password') }}" required autocomplete="current-password">

                                @error('user_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    
                        <label class="col-md-4 col-form-label text-md-right"></label>
                        <div class="col-md-6">
                            <div class="form-check form-check-inline">
                                <label class="form-check-label" for="show_password"><input type="checkbox" class="form-check-input" id="show_password"> 顯示密碼</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row step3 d-none">
                        <label id="captcha_label" for="captcha" class="col-md-4 col-form-label text-md-right">請輸入驗證碼</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control @error('captcha') is-invalid @enderror" id="captcha" name="captcha" required autocomplete="off">
                            
                            @error('captcha')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <label class="col-md-4 col-form-label"></label>
                        <div class="captcha col-md-6">
                            <span>{!! captcha_img() !!}</span>
                            <button type="button" class="btn btn-primary" class="reload" id="reload">
                                &#x21bb;
                            </button>
                        </div>
                    </div>


                    <br><br>

                    <div class="form-group row mb-0 justify-content-center">
                        <button type="button" class="btn btn-primary radius px-5" id="run" {{ old('user_number') ? ''  : 'disabled="disabled"' }}>
                            繼續
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
