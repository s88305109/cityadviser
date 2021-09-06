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
            refresh();
        });

        $("#run").click(function () {
            if($(".step1").is(":visible")) {
                $(".step1, .step3").hide();
                $(".step2").fadeIn('fast');
                $("#user_password").focus();
            } else if($(".step2").is(":visible")) {
                $(".step1, .step2").hide();
                $(".step3").fadeIn('fast');
                $("#captcha").focus();
            } else if($(".step3").is(":visible")) {
                $.ajax({
                    type: "POST",
                    url: "/login",
                    data: $(".login-form").serialize(),
                    dataType: "json",
                    success: function (response) {
                        if (response.status == "OK") {
                            window.location.href = "/";
                        } else {
                            alert(response.msg);
                            console.log(response.msg);
                            refresh();
                        }
                    },
                    error: function (thrownError) {
                        console.log(thrownError);
                    }
                });
            }
        });

        $(document).on('keypress',function(e) {
            if(e.which == 13) {
                $("#run").trigger("click");
            }
        });
    });

    function refresh() {
        $.ajax({
            type: "GET",
            url: "reload-captcha",
            success: function (data) {
                $(".captcha span").html(data.captcha);
            }
        });
    }
</script>

<style>
.step2, .step3{
    display: none;
}
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="row justify-content-center mt-2">
                <img src="/images/logo.jpg">
            </div>

            <div class="card-body">
                <form class="login-form needs-validation" method="POST" action="/login" novalidate>
                    @csrf

                    <div class="form-group row step1">
                        <label for="user_number" class="col-md-4 col-form-label text-md-right">請輸入帳號</label>

                        <div class="col-md-6">
                            <input type="text " class="form-control @error('user_number ') is-invalid @enderror" id="user_number" name="user_number" value="{{ old('user_number ') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row step2">
                        <label for="user_password" class="col-md-4 col-form-label text-md-right">請輸入密碼</label>

                        <div class="col-md-6">
                            <input type="password" class="form-control @error('user_password') is-invalid @enderror" id="user_password"  name="user_password" required autocomplete="current-password">

                            @error('user_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row step3">
                        <label for="captcha" class="col-md-4 col-form-label text-md-right">請輸入驗證碼</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control @error('captcha') is-invalid @enderror" id="captcha"  name="captcha" required autocomplete="off">

                            <div class="captcha">
                                <span>{!! captcha_img() !!}</span>
                                <button type="button" class="btn btn-primary" class="reload" id="reload">
                                    &#x21bb;
                                </button>
                            </div>

                            @error('captcha')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <br><br>

                    <div class="form-group row mb-0 justify-content-center">
                        <button type="button" class="btn btn-primary px-5" id="run">
                            繼續
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
