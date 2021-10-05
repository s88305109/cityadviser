@extends('layouts.app')

@section('content')

<script>
    $(document).ready(function () {
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

        $("#saveBtn").click(function () {
            showLoadingMask();
            allowRedirect = true;
            $("form.employee").submit();
        });

        $("#disableUser").click(function () {
            showLoadingMask();
            allowRedirect = true;
            $("form.employee").attr("action", "/organization/employee/lockUser");
            $("form.employee").submit();
        });

        $("#enableUser").click(function () {
            showLoadingMask();
            allowRedirect = true;
            $("form.employee").attr("action", "/organization/employee/unlockUser");
            $("form.employee").submit();
        });

        $("#date_employment").change(function () {
            $("#date_resignation").attr("min", $(this).val());
        });

        $(".btn.btn-outline-secondary").click(function () {
            $(".btn.btn-outline-secondary").removeClass("active");
            $(this).addClass("active");
        });

        $("#company_id").change(function() {
            $(".job-set").find("input:checked").prop("checked", false);
            $(".job-set").find(".btn").removeClass("active");

            checkCompanyType();
        });

        checkCompanyType();

        $("#date_resignation").change(function() {
            if ($(this).val() == "")
                $("#reason").val("");
        });

        $("ul.dropdown-menu li").click(function () {
            if ($(this).parent().parent().find("input").val() != $(this).html())
                isChanged = true;

            $(this).parent().parent().find("input").val($(this).html());
        });

        @if($errors->any())
        $(".is-invalid").eq(0).focus();
        @endif

        @error('user_id')
        showMessageModal("{{ $message }}");
        @enderror

        @if(old('show_password') == 1)
        $("#user_password").attr("type", "text");
        @endif
    });

    function checkCompanyType() {
        $(".job-set").eq(0).hide();
        $(".job-set").eq(1).hide();
        $(".staff-code-set").hide();

        if ($("#company_id").children("option:selected").data("type") == "1") {
            $(".job-set").eq(0).show();
            $(".staff-code-set").show();
        } else if ($("#company_id").children("option:selected").data("type") == "2") {
            $(".job-set").eq(1).show();
        }
    }
</script>

<div class="container employee-edit">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h4><i class="bi bi-person-plus"></i> 員工管理（{{ (empty($user->user_id)) ? '新增員工' : '編輯資料' }}）</h4>
            <div class="card">
                <div class="card-body @if(! empty($user->user_id) && $user->status != 1) bg-danger bg-opacity-25 @endif">
                    <form class="employee" method="POST" action="/organization/employee/save" novalidate>
                        @csrf

                        <input type="hidden" name="user_id" value="{{ $user->user_id }}">
                        <input type="hidden" name="state" value="{{ $state }}">

                        <div class="input-group inner-addon right-addon reset-icon mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text @error('name') text-danger border-danger @enderror">姓名</div>
                            </div>

                            <i class="bi bi-x-circle-fill text-danger"></i>
                            <input class="form-control @error('name') is-invalid @enderror" id="name" name="name" type="text" value="{{ ($errors->isEmpty()) ? $user->name : old('name') }}">

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="input-group inner-addon right-addon reset-icon mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text password-change-text @error('id_card') text-danger border-danger @enderror">身分證</div>
                            </div>

                            <i class="bi bi-x-circle-fill text-danger"></i>
                            <input class="form-control @error('id_card') is-invalid @enderror" id="id_card" name="id_card" type="text" value="{{ ($errors->isEmpty()) ? $user->id_card : old('id_card') }}">

                            @error('id_card')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="input-group inner-addon right-addon reset-icon mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text password-change-text @error('phone_number') text-danger border-danger @enderror">手機號碼</div>
                            </div>

                            <i class="bi bi-x-circle-fill text-danger"></i>
                            <input class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" type="text" value="{{ ($errors->isEmpty()) ? $user->phone_number : old('phone_number') }}">

                            @error('phone_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="input-group-top inner-addon right-addon reset-icon mb-2">
                            <div class="input-group">
                                <div class="input-group-text @error('email') text-danger border-danger @enderror">Email</div>
                            </div>

                            <i class="bi bi-x-circle-fill text-danger"></i>
                            <textarea class="form-control @error('email') is-invalid @enderror" id="email" name="email" rows="1" oninput="autoGrow(this);">{{ ($errors->isEmpty()) ? $user->email : old('email') }}</textarea>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text password-change-text @error('date_employment') text-danger border-danger @enderror">到職日期</div>
                            </div>

                            <input class="form-control @error('date_employment') is-invalid @enderror" id="date_employment" name="date_employment" type="date" value="{{ ($errors->isEmpty()) ? $user->date_employment : old('date_employment') }}">

                            @error('date_employment')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="input-group mb-2 @if(empty($user->user_id)) d-none @endif">
                            <div class="input-group-prepend">
                                <div class="input-group-text password-change-text @error('date_resignation') text-danger border-danger @enderror">離職日期</div>
                            </div>

                            <input class="form-control @error('date_resignation') is-invalid @enderror" id="date_resignation" name="date_resignation" type="date" min="{{ ($errors->isEmpty()) ? $user->date_employment : old('date_employment') }}" value="{{ ($errors->isEmpty()) ? $user->date_resignation : old('date_resignation') }}">

                            @error('date_resignation')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="input-group mb-2 @if(empty($user->user_id)) d-none @endif">
                            <div class="input-group-prepend">
                                <label class="input-group-text @error('reason') text-danger border-danger @enderror" for="reason">離職原因</label>
                            </div>

                            <input class="form-control @error('reason') is-invalid @enderror" id="reason" name="reason" type="text" value="{{ ($errors->isEmpty()) ? $user->reason : old('reason') }}">

                            <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown"></button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>生涯規劃</li>
                                <li>健康因素</li>
                                <li>不適任</li>
                            </ul>

                            @error('reason')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label class="form-label gender-label @error('gender_type') text-danger @enderror">性別</label>
                            
                            <input class="form-check-input @error('gender_type') is-invalid @enderror" id="gender_type1" name="gender_type" type="radio" value="1" @if('1' == (($errors->isEmpty()) ? $user->gender_type : old('gender_type'))) checked @endif>
                            <label class="form-check-label me-3" for="gender_type1">男</label>
                        
                            <input class="form-check-input @error('gender_type') is-invalid @enderror" id="gender_type0" name="gender_type" type="radio" value="0" @if('0' == (($errors->isEmpty()) ? $user->gender_type : old('gender_type'))) checked @endif>
                            <label class="form-check-label" for="gender_type0">女</label>
                            
                            @error('gender_type')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <label class="input-group-text @error('counties_city_type') text-danger border-danger @enderror" for="counties_city_type">縣市</label>
                            </div>

                            <select class="form-select @error('counties_city_type') is-invalid @enderror" id="counties_city_type" name="counties_city_type">
                                <option></option>
                                @foreach ($region as $row)
                                <option value="{{ $row->region_id }}" @if($row->region_id == (($errors->isEmpty()) ? $user->counties_city_type : old('counties_city_type'))) selected @endif>{{ $row->title }}</option>
                                @endforeach
                            </select>

                            @error('counties_city_type')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <label class="input-group-text @error('company_id') text-danger border-danger @enderror" for="company_id">所屬公司</label>
                            </div>

                            <select class="form-select @error('company_id') is-invalid @enderror" id="company_id" name="company_id">
                                <option></option>
                                @foreach ($company as $row)
                                <option value="{{ $row->company_id }}" data-type="{{ $row->type }}" @if($row->company_id == (($errors->isEmpty()) ? $user->company_id : old('company_id'))) selected @endif>{{ $row->company_name }}</option>
                                @endforeach
                            </select>

                            @error('company_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="card mb-2 job-set text-center @error('job_id') text-danger border-danger @enderror">
                            <div class="card-header @error('job_id') is-invalid border-danger @enderror">總公司職位設定</div>

                            @error('job_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                            <div class="row p-2">
                                @foreach ($job1 as $row)                                
                                <div class="col-6 text-center g-1">
                                    <input class="d-none" id="job{{ $row->job_id }}" name="job_id" type="radio" value="{{ $row->job_id }}" @if($row->job_id == (($errors->isEmpty()) ? $user->job_id : old('job_id'))) checked @endif autocomplete="off">
                                    <label class="btn btn-outline-secondary @if($row->job_id == (($errors->isEmpty()) ? $user->job_id : old('job_id'))) active @endif" for="job{{ $row->job_id }}">{{ $row->job_title }}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="card mb-2 job-set text-center @error('job_id') text-danger border-danger @enderror">
                            <div class="card-header @error('job_id') is-invalid border-danger @enderror">分公司職位設定</div>

                            @error('job_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                            <div class="row p-2">
                                @foreach ($job2 as $row)                                
                                <div class="col-6 text-center g-1">
                                    <input class="d-none" id="job{{ $row->job_id }}" name="job_id" type="radio" value="{{ $row->job_id }}" @if($row->job_id == (($errors->isEmpty()) ? $user->job_id : old('job_id'))) checked @endif autocomplete="off">
                                    <label class="btn btn-outline-secondary @if($row->job_id == (($errors->isEmpty()) ? $user->job_id : old('job_id'))) active @endif" for="job{{ $row->job_id }}">{{ $row->job_title }}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <hr>

                        <div class="input-group-top inner-addon right-addon reset-icon mb-2">
                            <div class="input-group">
                                <div class="input-group-text @error('user_number') text-danger border-danger @enderror">平台帳號</div>
                            </div>

                            <i class="bi bi-x-circle-fill text-danger"></i>
                            <input class="form-control @error('user_number') is-invalid @enderror" id="user_number" name="user_number" type="text" value="{{ ($errors->isEmpty()) ? $user->user_number : old('user_number') }}">

                            @error('user_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="input-group-top inner-addon right-addon mb-2">
                            <div class="input-group">
                                <div class="input-group-text @error('user_password') text-danger border-danger @enderror">平台密碼</div>
                            </div>

                            <i class="bi bi-eye-fill password-visible"></i>
                            <input class="form-control no-background-image @error('user_password') is-invalid @enderror" id="user_password" name="user_password" type="password" value="{{ old('user_password') }}" placeholder="8-25位數密碼，請區分大小寫">

                            @error('user_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="staff-code-set input-group-top inner-addon right-addon reset-icon mb-3">
                            <div class="input-group">
                                <div class="input-group-text @error('staff_code') text-danger border-danger @enderror">員工編號</div>
                            </div>
                            
                            <i class="bi bi-x-circle-fill text-danger"></i>
                            <input class="form-control @error('staff_code') is-invalid @enderror" id="staff_code" name="staff_code" type="text" value="{{ ($errors->isEmpty()) ? $user->staff_code : old('staff_code') }}">

                            @error('staff_code')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        @if ($user->status == 1)
                        <div class="mb-3">
                            <button class="btn btn-danger px-5 w-100" type="button" data-bs-toggle="modal" data-bs-target="#confirmDialog">凍結帳號</button>
                        </div>
                        @elseif(! empty($user->user_id) && empty($user->date_resignation))
                        <div class="mb-3">
                            <button class="btn btn-success px-5 w-100" type="button" data-bs-toggle="modal" data-bs-target="#confirmDialog2">解除凍結</button>
                        </div>
                        @endif

                        @if(! empty($user->user_id) && empty($user->date_resignation))
                        <div class="mb-3">
                            <button type="button" class="btn btn-primary px-5 w-100" onclick="window.location.href='/organization/employee/list/{{ $state }}/{{ $user->user_id }}/role'">客製化權限</button>
                        </div>
                        @endif

                        <input id="show_password" name="show_password" type="hidden" value="{{ old('show_password') }}">

                        <div class="mb-5">
                            <button type="button" class="btn btn-primary px-5 w-100" id="saveBtn">儲存</button>
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
            <div class="modal-body text-center">確定凍結此帳號嗎？</div>
            <div class="modal-footer justify-content-center">
                <button class="btn btn-danger untrigger" id="disableUser" type="button">　是　</button>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">　否　</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirmDialog2" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">確定解除凍結嗎？</div>
            <div class="modal-footer justify-content-center">
                <button class="btn btn-success untrigger" id="enableUser" type="button">　是　</button>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">　否　</button>
            </div>
        </div>
    </div>
</div>

@endsection
