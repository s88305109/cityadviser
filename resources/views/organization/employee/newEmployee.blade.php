@extends('layouts.app')

@section('content')

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

<style>
.input-group-top .input-group, .input-group-top .input-group-text { 
    width: 100%; 
}
.input-group-top .input-group-text { border-radius: 0.25em 0.25em 0 0; }
.input-group-top > input.form-control,
.input-group-top > textarea.form-control { 
    border-radius: 0 0 0.25em 0.25em; 
}
.input-group-top.inner-addon.reset-icon i.bi {
    margin-top: -1.8em;
}
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h4><i class="bi bi-person-plus"></i> 員工管理（新增員工）</h4>
            <div class="card">
                <div class="card-body">
                    <form class="new-employee" method="POST" action="/organization/employee/newEmployee" novalidate>
                        @csrf

                        <div class="form-group input-group inner-addon right-addon reset-icon">
                            <div class="input-group-prepend">
                                <div class="input-group-text @error('fullname') text-danger @enderror">姓名</div>
                            </div>
                            <i class="bi bi-x-circle-fill text-danger"></i>
                            <input class="form-control @error('fullname') is-invalid @enderror" id="fullname" name="fullname" type="text" value="{{ old('fullname') }}">
                        </div>

                        <div class="form-group input-group inner-addon right-addon reset-icon">
                            <div class="input-group-prepend">
                                <div class="input-group-text password-change-text @error('id_card') text-danger @enderror">身分證</div>
                            </div>
                            <i class="bi bi-x-circle-fill text-danger"></i>
                            <input class="form-control @error('id_card') text-danger @enderror" id="id_card" name="id_card" type="text" value="{{ old('id_card') }}">
                        </div>

                        <div class="form-group input-group inner-addon right-addon reset-icon">
                            <div class="input-group-prepend">
                                <div class="input-group-text password-change-text @error('phone_number') text-danger @enderror">手機號碼</div>
                            </div>
                            <i class="bi bi-x-circle-fill text-danger"></i>
                            <input class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" type="text" value="{{ old('phone_number') }}">
                        </div>

                        <div class="form-group input-group-top inner-addon right-addon reset-icon">
                            <div class="input-group">
                                <div class="input-group-text @error('email') text-danger @enderror">Email</div>
                            </div>
                            <i class="bi bi-x-circle-fill text-danger"></i>
                            <textarea class="form-control" id="email" name="email" rows="2">{{ old('email') }}</textarea>
                        </div>

                        <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text password-change-text @error('date_employment') text-danger @enderror">到職日期</div>
                            </div>
                            <input class="form-control @error('date_employment') is-invalid @enderror" id="date_employment" name="date_employment" type="date" value="{{ old('date_employment') }}">
                        </div>

                        <div class="form-group">
                            <label class="form-label text-center w-25">性別</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" id="gender_type1" name="gender_type" type="radio" value="1">
                                <label class="form-check-label" for="gender_type1">男</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" id="gender_type0" name="gender_type" type="radio" value="0">
                                <label class="form-check-label" for="gender_type0">女</label>
                            </div>
                        </div>

                        <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="counties_city_type">縣市</label>
                            </div>
                            <select class="custom-select" id="counties_city_type" name="counties_city_type">
                                <option selected></option>
                                @foreach ($region as $row)
                                <option value="{{ $row->region_id }}">{{ $row->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="company_id">所屬公司</label>
                            </div>
                            <select class="custom-select" id="company_id" name="company_id">
                                <option selected></option>
                            </select>
                        </div>

                        <div class="form-group">
                            <input type="radio" class="btn-check" name="options" id="option1" autocomplete="off" checked>
                            <label class="btn btn-secondary" for="option1">Checked</label>

                            <input type="radio" class="btn-check" name="options" id="option2" autocomplete="off">
                            <label class="btn btn-secondary" for="option2">Radio</label>

                            <input type="radio" class="btn-check" name="options" id="option3" autocomplete="off" disabled>
                            <label class="btn btn-secondary" for="option3">Disabled</label>

                            <input type="radio" class="btn-check" name="options" id="option4" autocomplete="off">
                            <label class="btn btn-secondary" for="option4">Radio</label>
                        </div>

                        <div class="form-group row mb-0 justify-content-center mb-5">
                            <button type="button" class="btn btn-primary px-5" id="saveBtn">
                                新增
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
                <button class="btn btn-primary untrigger" id="modifyPassword" type="button">　是　</button>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <button class="btn btn-secondary" type="button" data-dismiss="modal">　否　</button>
            </div>
        </div>
    </div>
</div>

@endsection
