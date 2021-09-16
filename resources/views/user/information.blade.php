@extends('layouts.app')

@section('content')

<style>
    .password-change-text { 
        min-width: 100px;
        display: inline-block;
    }
    #old_password, #confirm_password { background-image: none; }
    .password-change-text.text-danger{ border-color: #e3342f; }
</style>

<script>
    $(document).ready(function () {
        $("i.password-visible").click(function () {
            var obj = $(this).parent().find("input");

            if($(obj).attr("type") == "password") {
                $("#old_password, #new_password, #confirm_password").attr("type", "text");
                $("#show_password").val(1);
            } else {
                $("#old_password, #new_password, #confirm_password").attr("type", "password");
                $("#show_password").val(0);
            }
        });

        $("#doCheck").click(function () {
            if ($("#old_password").val() == "") {
                showMessageModal("請輸入目前密碼");
                objectShake($("#old_password").parent());
                return false;
            } else if ($("#new_password").val() == "") {
                showMessageModal("請輸入新密碼");
                objectShake($("#new_password").parent());
                return false;
            } else if ($("#confirm_password").val() == "") {
                showMessageModal("請輸入確認新密碼");
                objectShake($("#confirm_password").parent());
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
        objectShake($("#confirm_password").parent());
        @enderror

        @error('new_password')
        showMessageModal("{{ $message }}");
        objectShake($("#new_password").parent());
        @enderror

        @error('old_password')
        showMessageModal("{{ $message }}");
        objectShake($("#old_password").parent());
        @enderror

        @if(old('show_password') == 1)
        $("#old_password, #new_password, #confirm_password").attr("type", "text");
        @endif
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

                        <div class="form-group">
                            <label for="fullname">姓名</label>
                            <input class="form-control" type="text" readonly>
                        </div>
                        <div class="form-group">
                            <label for="phone">手機號碼</label>
                            <input class="form-control" type="text" readonly>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input class="form-control" type="text" readonly>
                        </div>

                        <hr>

                        <div class="form-group">
                            <div class="input-group mb-2 inner-addon right-addon">
                                <div class="input-group-prepend">
                                    <div class="input-group-text password-change-text @error('old_password') text-danger @enderror">目前密碼</div>
                                </div>
                                <i class="bi bi-eye-fill password-visible"></i>
                                <input class="form-control @error('old_password') is-invalid @enderror" id="old_password" name="old_password" type="password" value="{{ old('old_password') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group mb-2 inner-addon right-addon">
                                <div class="input-group-prepend">
                                    <div class="input-group-text password-change-text @error('new_password') text-danger @enderror">新密碼</div>
                                </div>
                                <i class="bi bi-eye-fill password-visible"></i>
                                <input class="form-control @error('new_password') text-danger @enderror" id="new_password" name="new_password" type="password" value="{{ old('new_password') }}" placeholder="8-25位數密碼，請區分大小寫">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group mb-2 inner-addon right-addon">
                                <div class="input-group-prepend">
                                    <div class="input-group-text password-change-text @error('confirm_password') text-danger @enderror">確認新密碼</div>
                                </div>
                                <i class="bi bi-eye-fill password-visible"></i>
                                <input class="form-control @error('confirm_password') is-invalid @enderror" id="confirm_password" name="confirm_password" type="password" value="{{ old('confirm_password') }}"  placeholder="8-25位數密碼，請區分大小寫">
                            </div>
                        </div>

                        <div class="form-group row mb-0 justify-content-center">
                            <button type="button" class="btn btn-primary px-5" id="doCheck">
                                修改密碼
                            </button>
                        </div>

                        <input id="show_password" name="show_password" type="hidden" value="{{ old('show_password') }}">
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
                <button class="btn btn-primary untrigger" id="modifyPassword" type="button">　是　</button>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <button class="btn btn-secondary" type="button" data-dismiss="modal">　否　</button>
            </div>
        </div>
    </div>
</div>

@endsection
