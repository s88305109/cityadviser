@extends('layouts.app')

@section('content')

<style>
.input-group-top .input-group, .input-group-top .input-group-text { 
    width: 100%; 
    border-bottom: 0;
}
.input-group-top .input-group-text { border-radius: 0.25em 0.25em 0 0; }
.input-group-top > input.form-control,
.input-group-top > textarea.form-control { 
    border-radius: 0 0 0.25em 0.25em; 
}
.input-group-top.inner-addon.reset-icon i.bi {
    margin-top: -1.8em;
}
 .job-set .btn { min-width: 88px; }
 .job-set .card-header { text-align: center; }
 .input-group-text, .gender-label { 
    min-width: 88px; 
    display: inline-block;
    text-align: center;
}
</style>

<script>
    $(document).ready(function () {
        $("#saveBtn").click(function () {
            allowRedirect = true;
            $(".new-employee").submit();
        });

        $(".btn.btn-outline-secondary").click(function () {
            $(".btn.btn-outline-secondary").removeClass('active');
            $(this).addClass('active');
        });
    });
</script>

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
                                <div class="input-group-text @error('name') text-danger border-danger @enderror">姓名</div>
                            </div>
                            <i class="bi bi-x-circle-fill text-danger"></i>
                            <input class="form-control @error('name') is-invalid @enderror" id="name" name="name" type="text" value="{{ old('name') }}">

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group input-group inner-addon right-addon reset-icon">
                            <div class="input-group-prepend">
                                <div class="input-group-text password-change-text @error('id_card') text-danger border-danger @enderror">身分證</div>
                            </div>
                            <i class="bi bi-x-circle-fill text-danger"></i>
                            <input class="form-control @error('id_card') is-invalid @enderror" id="id_card" name="id_card" type="text" value="{{ old('id_card') }}">

                            @error('id_card')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group input-group inner-addon right-addon reset-icon">
                            <div class="input-group-prepend">
                                <div class="input-group-text password-change-text @error('phone_number') text-danger border-danger @enderror">手機號碼</div>
                            </div>
                            <i class="bi bi-x-circle-fill text-danger"></i>
                            <input class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" type="text" value="{{ old('phone_number') }}">

                            @error('phone_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group input-group-top inner-addon right-addon reset-icon">
                            <div class="input-group">
                                <div class="input-group-text @error('email') text-danger border-danger @enderror">Email</div>
                            </div>
                            <i class="bi bi-x-circle-fill text-danger"></i>
                            <textarea class="form-control @error('email') is-invalid @enderror" id="email" name="email" rows="2">{{ old('email') }}</textarea>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text password-change-text @error('date_employment') text-danger border-danger @enderror">到職日期</div>
                            </div>
                            <input class="form-control @error('date_employment') is-invalid @enderror" id="date_employment" name="date_employment" type="date" value="{{ old('date_employment') }}">

                            @error('date_employment')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group mb-2">
                            <label class="form-label gender-label @error('gender_type') text-danger @enderror">性別</label>
                            <div class="form-check form-check-inline ml-1">
                                <input class="form-check-input @error('gender_type') is-invalid @enderror" id="gender_type1" name="gender_type" type="radio" value="1" @if(old('gender_type') == '1') checked @endif>
                                <label class="form-check-label" for="gender_type1">男</label>
                            </div>
                            <div class="form-check form-check-inline ml-1">
                                <input class="form-check-input @error('gender_type') is-invalid @enderror" id="gender_type0" name="gender_type" type="radio" value="0" @if(old('gender_type') == '0') checked @endif>
                                <label class="form-check-label" for="gender_type0">女</label>
                            </div>

                            @error('gender_type')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <label class="input-group-text @error('counties_city_type') text-danger border-danger @enderror" for="counties_city_type">縣市</label>
                            </div>
                            <select class="custom-select @error('counties_city_type') is-invalid @enderror" id="counties_city_type" name="counties_city_type">
                                <option></option>
                                @foreach ($region as $row)
                                <option value="{{ $row->region_id }}" @if(old('counties_city_type') == $row->region_id) selected @endif>{{ $row->title }}</option>
                                @endforeach
                            </select>

                            @error('counties_city_type')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <label class="input-group-text @error('company_id') text-danger border-danger @enderror" for="company_id">所屬公司</label>
                            </div>
                            <select class="custom-select @error('company_id') is-invalid @enderror" id="company_id" name="company_id">
                                <option></option>
                                @foreach ($company as $row)
                                <option value="{{ $row->company_id }}" data-type="{{ $row->type }}" @if(old('company_id') == $row->company_id) selected @endif>{{ $row->company_name }}</option>
                                @endforeach
                            </select>

                            @error('company_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="card mb-3 job-set text-center @error('job_id') text-danger border-danger @enderror">
                            <div class="card-header @error('job_id') is-invalid border-danger @enderror">總公司職位設定</div>

                            @error('job_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                            <div class="row p-2">
                                @foreach ($job1 as $row)                                
                                <div class="col-6 text-center">
                                    <input class="d-none" id="job{{ $row->job_id }}" name="job_id" type="radio" value="{{ $row->job_id }}" @if(old('job_id') == $row->job_id) checked @endif autocomplete="off">
                                    <label class="btn btn-outline-secondary @if(old('job_id') == $row->job_id) active @endif" for="job{{ $row->job_id }}">{{ $row->job_title }}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="card mb-3 job-set text-center @error('job_id') text-danger border-danger @enderror">
                            <div class="card-header @error('job_id') is-invalid border-danger @enderror">分公司職位設定</div>

                            @error('job_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                            <div class="row p-2">
                                @foreach ($job2 as $row)                                
                                <div class="col-6 text-center">
                                    <input class="d-none" id="job{{ $row->job_id }}" name="job_id" type="radio" value="{{ $row->job_id }}" @if(old('job_id') == $row->job_id) checked @endif autocomplete="off">
                                    <label class="btn btn-outline-secondary @if(old('job_id') == $row->job_id) active @endif" for="job{{ $row->job_id }}">{{ $row->job_title }}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <hr>

                        <div class="form-group input-group-top inner-addon right-addon reset-icon">
                            <div class="input-group">
                                <div class="input-group-text @error('user_number') text-danger border-danger @enderror">平台帳號</div>
                            </div>
                            <i class="bi bi-x-circle-fill text-danger"></i>
                            <input class="form-control @error('user_number') is-invalid @enderror" id="user_number" name="user_number" type="text" value="{{ old('user_number') }}">

                            @error('user_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group input-group-top inner-addon right-addon reset-icon">
                            <div class="input-group">
                                <div class="input-group-text @error('user_password') text-danger @enderror">平台密碼</div>
                            </div>
                            <i class="bi bi-x-circle-fill text-danger"></i>
                            <input class="form-control @error('user_password') is-invalid @enderror" id="user_password" name="user_password" type="password" value="{{ old('user_password') }}">

                            @error('user_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <button type="button" class="btn btn-primary px-5 w-100">客製化權限</button>
                        </div>

                        <div class="mb-5">
                            <button type="button" class="btn btn-primary px-5 w-100" id="saveBtn">新增</button>
                        </div>

                        <div class="modal fade" id="confirmDialog" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-body text-center">
                                        <p>請指定員工編號</p>
                                        <div class="form-group input-group inner-addon right-addon reset-icon">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text @error('staff_code') text-danger @enderror">員工編號</div>
                                            </div>
                                            <i class="bi bi-x-circle-fill text-danger"></i>
                                            <input class="form-control @error('staff_code') is-invalid @enderror" id="staff_code" name="staff_code" type="text" value="{{ old('staff_code') }}">
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-center">
                                        <button class="btn btn-primary untrigger" id="modifyStaffCode" type="button">指定</button>
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        <button class="btn btn-secondary" type="button" data-dismiss="modal">取消</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
