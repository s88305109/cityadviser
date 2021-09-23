@extends('layouts.app')

@section('content')

<script>
    $(document).ready(function () {
        $("#saveBtn").click(function () {
            allowRedirect = true;
            $(".new-employee").submit();
        });

        $(".btn.btn-outline-secondary").click(function () {
            $(".btn.btn-outline-secondary").removeClass("active");
            $(this).addClass("active");
        });

        $("#company_id").change(function() {
            $(".job-set").find("input:checked").prop("checked", false);
            $(".job-set").find(".btn").removeClass("active");

            if ($(this).children("option:selected").data("type") == "2") {
                $(".job-set").eq(0).hide();
                $(".job-set").eq(1).show();
            } else {
                $(".job-set").eq(0).show();
                $(".job-set").eq(1).hide();
            }
        });

        @if($errors->any())
        $(".is-invalid").eq(0).focus();
        @endif

        @error('staff_code')
        $("#confirmDialog").modal("show");
        @enderror
    });
</script>

<style>
.job-set { display: none; }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h4><i class="bi bi-person-plus"></i> 員工管理（編輯資料）</h4>
            <div class="card">
                <div class="card-body">
                    <form class="new-employee" method="POST" action="/organization/employee/newEmployee" novalidate>
                        @csrf

                        <input type="hidden" name="user_id" value="{{ $user->user_id }}">

                        <div class="input-group inner-addon right-addon reset-icon mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text @error('name') text-danger border-danger @enderror">姓名</div>
                            </div>
                            <i class="bi bi-x-circle-fill text-danger"></i>
                            <input class="form-control @error('name') is-invalid @enderror" id="name" name="name" type="text" value="{{ old('name') ?? $user->name }}">

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
                            <input class="form-control @error('id_card') is-invalid @enderror" id="id_card" name="id_card" type="text" value="{{ old('id_card') ?? $user->id_card }}">

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
                            <input class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" type="text" value="{{ old('phone_number') ?? $user->phone_number }}">

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
                            <textarea class="form-control @error('email') is-invalid @enderror" id="email" name="email" rows="2">{{ old('email') ?? $user->email }}</textarea>

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
                            <input class="form-control @error('date_employment') is-invalid @enderror" id="date_employment" name="date_employment" type="date" value="{{ old('date_employment') ?? $user->date_employment }}">

                            @error('date_employment')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label class="form-label gender-label @error('gender_type') text-danger @enderror">性別</label>
                            
                            <input class="form-check-input @error('gender_type') is-invalid @enderror" id="gender_type1" name="gender_type" type="radio" value="1" @if(old('gender_type') == '1' || $user->gender_type == '1') checked @endif>
                            <label class="form-check-label me-3" for="gender_type1">男</label>
                        
                            <input class="form-check-input @error('gender_type') is-invalid @enderror" id="gender_type0" name="gender_type" type="radio" value="0" @if(old('gender_type') == '0' || $user->gender_type == '0') checked @endif>
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
                                <option value="{{ $row->region_id }}" @if(old('counties_city_type') == $row->region_id || $user->counties_city_type == $row->region_id) selected @endif>{{ $row->title }}</option>
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
                                <option value="{{ $row->company_id }}" data-type="{{ $row->type }}" @if(old('company_id') == $row->company_id || $user->company_id == $row->company_id) selected @endif>{{ $row->company_name }}</option>
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
                                <div class="col-6 text-center mb-1">
                                    <input class="d-none" id="job{{ $row->job_id }}" name="job_id" type="radio" value="{{ $row->job_id }}" @if(old('job_id') == $row->job_id || $user->job_id == $row->job_id) checked @endif autocomplete="off">
                                    <label class="btn btn-outline-secondary @if(old('job_id') == $row->job_id || $user->job_id == $row->job_id) active @endif" for="job{{ $row->job_id }}">{{ $row->job_title }}</label>
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
                                <div class="col-6 text-center mb-1">
                                    <input class="d-none" id="job{{ $row->job_id }}" name="job_id" type="radio" value="{{ $row->job_id }}" @if(old('job_id') == $row->job_id || $user->job_id == $row->job_id) checked @endif autocomplete="off">
                                    <label class="btn btn-outline-secondary @if(old('job_id') == $row->job_id || $user->job_id == $row->job_id) active @endif" for="job{{ $row->job_id }}">{{ $row->job_title }}</label>
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
                            <input class="form-control @error('user_number') is-invalid @enderror" id="user_number" name="user_number" type="text" value="{{ old('user_number') ?? $user->user_number }}">

                            @error('user_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="input-group-top inner-addon right-addon reset-icon mb-3">
                            <div class="input-group">
                                <div class="input-group-text @error('user_password') text-danger border-danger @enderror">平台密碼</div>
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
                            <button type="button" class="btn btn-danger px-5 w-100">凍結帳號</button>
                        </div>

                        <div class="mb-3">
                            <button type="button" class="btn btn-primary px-5 w-100">客製化權限</button>
                        </div>

                        <div class="mb-5">
                            <button type="button" class="btn btn-primary px-5 w-100" id="saveBtn">儲存</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
