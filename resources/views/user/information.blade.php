@extends('layouts.app')

@section('content')

<style>
    .password-change-text { 
        min-width: 100px;
        display: inline-block;
    }
    #old_password, #confirm_password {
        background-image: none;
    }
    .password-change-text.text-danger{
        border-color: #e3342f;
    }
</style>

<script type="text/javascript">
    $(document).ready(function () {
        $("i.password-visible").click(function () {
            var obj = $(this).parent().find("input");

            if($(obj).attr("type") == "password") {
                $("#old_password, #new_password, #confirm_password").attr("type", "text");
            } else {
                $("#old_password, #new_password, #confirm_password").attr("type", "password");
            }
        });

        $("#doCheck").click(function () {
            if ($("#old_password").val() == "") {
                showMessageModal("請輸入目前密碼");
                return false;
            } else if ($("#new_password").val() == "") {
                showMessageModal("請輸入新密碼");
                return false;
            } else if ($("#confirm_password").val() == "") {
                showMessageModal("請輸入確認新密碼");
                return false;
            }

            $("#confirmDialog").modal("show");
        });

        $("#modifyPassword").click(function () {
            $(".change-password").submit();
        });

        @error('modify_failed')
        showMessageModal("{{ $message }}");
        @enderror

        @error('confirm_password')
        showMessageModal("{{ $message }}");
        @enderror

        @error('old_password')
        showMessageModal("{{ $message }}");
        @enderror
    });
</script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h4><i class="bi bi-person"></i> 個人資料</h4>
            <div class="card">
                <div class="card-body">
                    <form class="change-password" method="POST" action="/user/information" novalidate>
                        @csrf

                        <!--
                        <div class="form-group">
                            <label for="user_number">使用者帳號</label>
                            <input type="text" class="form-control" id="user_number" value="{{ $user->user_number }}" readonly>
                        </div>
                        -->

                        <div class="form-group">
                            <label for="fullname">姓名</label>
                            <input type="text" class="form-control" id="fullname" readonly>
                        </div>
                        <div class="form-group">
                            <label for="phone">手機號碼</label>
                            <input type="text" class="form-control" id="phone" readonly>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" id="email" readonly>
                        </div>

                        <hr>

                        <div class="form-group">
                            <div class="input-group mb-2 inner-addon right-addon">
                                <div class="input-group-prepend">
                                    <div class="input-group-text password-change-text @error('old_password') text-danger @enderror">目前密碼</div>
                                </div>
                                <i class="bi bi-eye-fill password-visible"></i>
                                <input type="password" class="form-control @error('old_password') is-invalid @enderror" id="old_password" name="old_password" value="{{ old('old_password') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group mb-2 inner-addon right-addon">
                                <div class="input-group-prepend">
                                    <div class="input-group-text password-change-text">新密碼</div>
                                </div>
                                <i class="bi bi-eye-fill password-visible"></i>
                                <input type="password" class="form-control" id="new_password" name="new_password" value="{{ old('new_password') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group mb-2 inner-addon right-addon">
                                <div class="input-group-prepend">
                                    <div class="input-group-text password-change-text @error('confirm_password') text-danger @enderror">確認新密碼</div>
                                </div>
                                <i class="bi bi-eye-fill password-visible"></i>
                                <input type="password" class="form-control @error('confirm_password') is-invalid @enderror" id="confirm_password" name="confirm_password" value="{{ old('confirm_password') }}">
                            </div>
                        </div>

                        <div class="form-group row mb-0 justify-content-center">
                            <button type="button" class="btn btn-primary px-5" id="doCheck">
                                修改密碼
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirmDialog" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                確定修改密碼？
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-primary" id="modifyPassword">　是　</button>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <button type="button" class="btn btn-secondary" data-dismiss="modal">　否　</button>
            </div>
        </div>
    </div>
</div>

@endsection
