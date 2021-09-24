@extends('layouts.app')

@section('content')

<script>
    $(document).ready(function () {
        $("#saveBtn").click(function () {
            allowRedirect = true;
            $(".new-company").submit();
        });

        @if($errors->any())
        $(".is-invalid").eq(0).focus();
        @endif
    });
</script>

<style>
.job-set { display: none; }
.input-group-text  { min-width: 92px; }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h4><i class="bi bi-building"></i> 公司管理（新增公司）</h4>
            <div class="card">
                <div class="card-body">
                    <form class="new-company" method="POST" action="/organization/company/newCompany" novalidate>
                        @csrf

                        <div class="input-group-top inner-addon right-addon reset-icon mb-2">
                            <div class="input-group">
                                <div class="input-group-text @error('company_name') text-danger border-danger @enderror">公司名稱</div>
                            </div>
                            <i class="bi bi-x-circle-fill text-danger"></i>
                            <input class="form-control @error('company_name') is-invalid @enderror" id="company_name" name="company_name" type="text" value="{{ old('company_name') }}">

                            @error('company_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="input-group-top inner-addon right-addon reset-icon mb-2">
                            <div class="input-group">
                                <div class="input-group-text @error('company_address') text-danger border-danger @enderror">公司地址</div>
                            </div>
                            <i class="bi bi-x-circle-fill text-danger"></i>
                            <input class="form-control @error('company_address') is-invalid @enderror" id="company_address" name="company_address" type="text" value="{{ old('company_address') }}">

                            @error('company_address')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="input-group-top inner-addon right-addon reset-icon mb-2">
                            <div class="input-group">
                                <div class="input-group-text @error('company_no') text-danger border-danger @enderror">公司統一編號</div>
                            </div>
                            <i class="bi bi-x-circle-fill text-danger"></i>
                            <input class="form-control @error('company_no') is-invalid @enderror" id="company_no" name="company_no" type="text" value="{{ old('company_no') }}">

                            @error('company_no')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="input-group inner-addon right-addon reset-icon mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text password-change-text @error('phone_number') text-danger border-danger @enderror">公司電話</div>
                            </div>
                            <i class="bi bi-x-circle-fill text-danger"></i>
                            <input class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" type="text" value="{{ old('phone_number') }}">

                            @error('phone_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <label class="input-group-text @error('company_city') text-danger border-danger @enderror" for="company_city">縣市</label>
                            </div>
                            <select class="form-select @error('company_city') is-invalid @enderror" id="company_city" name="company_city">
                                <option></option>
                                @foreach ($region as $row)
                                <option value="{{ $row->region_id }}" @if(old('company_city') == $row->region_id) selected @endif>{{ $row->title }}</option>
                                @endforeach
                            </select>

                            @error('company_city')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="input-group-top inner-addon right-addon reset-icon mb-2">
                            <div class="input-group">
                                <div class="input-group-text @error('company_mail') text-danger border-danger @enderror">公司Email</div>
                            </div>
                            <i class="bi bi-x-circle-fill text-danger"></i>
                            <textarea class="form-control @error('company_mail') is-invalid @enderror" id="company_mail" name="company_mail" rows="2">{{ old('company_mail') }}</textarea>

                            @error('company_mail')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="input-group inner-addon right-addon reset-icon mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text password-change-text @error('company_bank_id') text-danger border-danger @enderror">公司銀行代號</div>
                            </div>
                            <i class="bi bi-x-circle-fill text-danger"></i>
                            <input class="form-control @error('company_bank_id') is-invalid @enderror" id="company_bank_id" name="company_bank_id" type="text" value="{{ old('company_bank_id') }}">

                            @error('company_bank_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="input-group-top inner-addon right-addon reset-icon mb-3">
                            <div class="input-group">
                                <div class="input-group-text @error('company_bank_account') text-danger border-danger @enderror">公司銀行帳戶</div>
                            </div>
                            <i class="bi bi-x-circle-fill text-danger"></i>
                            <input class="form-control @error('company_bank_account') is-invalid @enderror" id="company_bank_account" name="company_bank_account" type="text" value="{{ old('company_bank_account') }}">

                            @error('company_bank_account')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
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
