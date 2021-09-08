@extends('layouts.app')

@section('content')

<script type="text/javascript">
    $(document).ready(function () {
        $("#reload").click(function () {
            refreshCaptcha();
        });

        $("#showPassword").click(function () {
            if($(this).is(":checked")) {
                $("#user_password").attr("type", "text");
            } else {
                $("#user_password").attr("type", "password");
            }
        });
    });

    function refreshCaptcha() {
        $.get("/reload-captcha").done(function(data){
            $(".captcha span").html(data.captcha);
            $("#captcha").val("");
        });
    }
</script>

<style>
.custom-field {
    position: relative;
    font-size: 14px;
    border-top: 20px solid transparent;
    margin-bottom: 5px;
    --field-padding: 12px;
    width: 100%;
}

.custom-field .placeholder {
    position: absolute;
    left: var(--field-padding);
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
    line-height: 100%;
    transform: translateY(-50%);
    top: 1px;
    font-size: 14px;
    color: #222;
    background-color: #fff;
    width: auto;
}
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-body">
                <form class="login-form" method="POST" action="/login" novalidate>

                    <h3>內置標題文字表單</h3>
                    <div class="form-group row step1">
                        <div class="col-md-6">
                            <label class="custom-field one">
                                <input type="text" class="form-control" placeholder=" "/>
                                <span class="placeholder">請輸入帳號</span>
                            </label>
                        </div>
                    </div>

                    <hr>
                    <h3>一般Bootstrap表單元件</h3>
                    <div class="form-group row">
                        <label id="user_number_label" for="user_number" class="col-md-4 col-form-label text-md-right">請輸入帳號</label>

                        <div class="col-md-6">
                            <div class="inner-addon right-addon reset-icon">
                                <i class="bi bi-x-circle-fill text-danger"></i>
                                <input type="text" class="form-control" id="user_number" name="user_number" value="" required autofocus>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label id="user_number_label2" for="user_number2" class="col-md-4 col-form-label text-md-right text-danger">請輸入帳號</label>

                        <div class="col-md-6">
                            <div class="inner-addon right-addon reset-icon">
                                <i class="bi bi-x-circle-fill text-danger"></i>
                                <input type="text" class="form-control is-invalid" id="user_number2" name="user_number2" value="" required>
                            </div>

                            <span class="invalid-feedback" role="alert">
                                <strong>帳號錯誤</strong>
                            </span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label id="user_password_label" for="user_password" class="col-md-4 col-form-label text-md-right">請輸入密碼</label>

                        <div class="col-md-6">
                            <div class="inner-addon right-addon reset-icon">
                                <i class="bi bi-x-circle-fill text-danger"></i>
                                <input type="password" class="form-control @error('user_password') is-invalid @enderror" id="user_password"  name="user_password" value="{{ old('user_password') }}" required autocomplete="current-password">
                            </div>

                            @error('user_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    
                        <label class="col-md-4 col-form-label text-md-right"></label>
                        <div class="col-md-6">
                            <div class="form-check form-check-inline">
                                <label class="form-check-label" for="showPassword"><input type="checkbox" class="form-check-input" id="showPassword"> 顯示密碼</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-0 justify-content-center">
                        <button type="button" class="btn btn-primary radius px-5">
                            繼續
                        </button>
                    </div>

                    <hr>
                    <h3>圖片驗證碼</h3>
                    <div class="form-group row">
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

                    <hr>
                    <h3>Loading Mask</h3>
                    <div class="row">
                        <div class="col-md-3">
                            <button type="button" class="btn btn-primary" onclick="showLoadingMask();">SHOW</button>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-primary" onclick="hideLoadingMask();" style="z-index:10000;position: absolute;">HIDE</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
