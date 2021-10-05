@extends('layouts.app')

@section('content')

<script>
    $(document).ready(function () {
        $("#principal_name").keyup(function () {
            $(".ok-mark").hide();
            $("#principal").val("");

            if ($(this).val() == "")
                $("#principal_name").dropdown("hide");
            else {
                findUser();
            }
        }).blur(function () {
            setTimeout(function(){ $("#principal_name").dropdown("hide"); }, 100);
        });

        $("#confirmDisableCompany").click(function () {
            showLoadingMask();
            allowRedirect = true;
            $("form.company").attr("action", "/organization/company/lockCompany");
            $("form.company").submit();
        });

        $("#confirmEnableCompany").click(function () {
            showLoadingMask();
            allowRedirect = true;
            $("form.company").attr("action", "/organization/company/unlockCompany");
            $("form.company").submit();
        });

        @error('company_id')
        showMessageModal("{{ $message }}");
        @enderror

        @if($errors->any())
        $(".is-invalid").eq(0).focus();
        @endif
    });

    function fromSubmit() {
        if ($("#principal").val() != "" && $("#old_principal").val() != "" && $("#principal").val() != $("#old_principal").val()) {
            showConfirmModal("目前負責人為" + $("#old_principal").data("name") + "，確定要更換成" + $("#principal_name").val() + "？", "forceSubmit();");
        } else {
            showConfirmModal("確定儲存嗎？", "forceSubmit();");
        }
    }

    function forceSubmit() {
        showLoadingMask();
        allowRedirect = true;
        $("form.company").submit();
    }

    var loading = false;
        
    function findUser() {
        if (loading == true)
            return false;

        loading = true;

        $.ajax({
            type: "POST",
            url: "/organization/company/findUser",
            data: $("form.company").serialize(),
            dataType: "json",
            success: function (response) {
                loading = false;

                $(".dropdown-menu").html("");

                for(var k in response) {
                    $(".dropdown-menu").css("width", $("#principal_name").css("width")).append("<li data-id=\"" + response[k].user_id + "\">" + response[k].name + "</li>");

                    $(".dropdown-menu li").click(function () {
                        $("#principal_name").val($(this).html());
                        $("#principal_name").dropdown("hide");
                        $("#principal").val($(this).data("id"));
                        $(".ok-mark").removeClass("d-none").show();
                    });

                    $("#principal_name").dropdown("show");
                }
            },
            error: function (thrownError) {
                console.log(thrownError);  
                loading = false;
            }
        });
    }

    function lockConfirm() {
        $("#confirmDialog .modal-body").html("確定凍結<strong class=\"text-danger\">" + $("#company_name").val() + "</strong>嗎？");
        $("#confirmDialog").modal("show");
    }

    function unlockConfirm() {
        $("#confirmDialog2 .modal-body").html("確定解除凍結<strong class=\"text-danger\">" + $("#company_name").val() + "</strong>嗎？");
        $("#confirmDialog2").modal("show");
    }
</script>

<div class="container company-edit">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h4><i class="bi bi-building"></i> 公司管理（編輯資料）</h4>
            <div class="card">
                <div class="card-body @if(! empty($company->company_id) && $company->status != 1) bg-light-red @endif">
                    <form class="company" method="POST" action="/organization/company/saveCompany" novalidate>
                        @csrf

                        <input type="hidden" name="company_id" value="{{ $company->company_id }}">
                        <input type="hidden" name="area" value="{{ $area }}">

                        <div class="input-group-top inner-addon right-addon reset-icon mb-2">
                            <div class="input-group">
                                <div class="input-group-text @error('area_manager') text-danger border-danger @enderror">通路區經理</div>
                            </div>
                            
                            <select class="form-select @error('area_manager') is-invalid @enderror" id="area_manager" name="area_manager">
                                <option></option>
                                @foreach($managers as $row)
                                <option value="{{ $row->user_id }}" @if($row->user_id == (($errors->isEmpty()) ? $company->area_manager : old('area_manager'))) selected @endif>{{ $row->name }}</option>
                                @endforeach
                            </select>
                            
                            @error('area_manager')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="input-group-top inner-addon right-addon reset-icon mb-2">
                            <div class="input-group">
                                <div class="input-group-text @error('principal_name') text-danger border-danger @enderror">公司負責人</div>
                            </div>
                            
                            <i class="bi bi-x-circle-fill text-danger"></i>
                            <input class="form-control @error('principal_name') is-invalid @enderror" id="principal_name" name="principal_name" type="text" value="{{ ($errors->isEmpty()) ? $company->principal_name : old('principal_name') }}" autocomplete="off" placeholder="請輸入關鍵字">
                            <input id="principal" name="principal" type="hidden" value="{{ ($errors->isEmpty()) ? $company->principal : old('principal') }}">
                            <input id="old_principal" type="hidden" data-name="{{ $company->principal_name }}" value="{{ $company->principal }}">
                            <span class="badge bg-primary ok-mark @if((! $errors->isEmpty() & ! old('principal_id')) | ($errors->isEmpty() & empty($company->principal))) d-none @endif">OK</span>
                            
                            <ul class="dropdown-menu" aria-labelledby="principal_name"></ul>
                            
                            @error('principal_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="input-group-top inner-addon right-addon reset-icon mb-2">
                            <div class="input-group">
                                <div class="input-group-text @error('company_name') text-danger border-danger @enderror">公司名稱</div>
                            </div>
                            
                            <i class="bi bi-x-circle-fill text-danger"></i>
                            <textarea class="form-control @error('company_name') is-invalid @enderror" id="company_name" name="company_name" rows="1" oninput="autoGrow(this);">{{ ($errors->isEmpty()) ? $company->company_name : old('company_name') }}</textarea>

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
                            <textarea class="form-control @error('company_address') is-invalid @enderror" id="company_address" name="company_address" rows="1" oninput="autoGrow(this);">{{ ($errors->isEmpty()) ? $company->company_address : old('company_address') }}</textarea>

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
                            <input class="form-control @error('company_no') is-invalid @enderror" id="company_no" name="company_no" type="text" maxlength="8" value="{{ ($errors->isEmpty()) ? $company->company_no : old('company_no') }}">

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
                            <input class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" type="text" value="{{ ($errors->isEmpty()) ? $company->phone_number : old('phone_number') }}">

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
                                <option value="{{ $row->region_id }}" @if($row->region_id == (($errors->isEmpty()) ? $company->company_city : old('company_city'))) selected @endif>{{ $row->title }}</option>
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
                            <textarea class="form-control @error('company_mail') is-invalid @enderror" id="company_mail" name="company_mail" rows="1" oninput="autoGrow(this);">{{ ($errors->isEmpty()) ? $company->company_mail : old('company_mail') }}</textarea>

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
                            <input class="form-control @error('company_bank_id') is-invalid @enderror" id="company_bank_id" name="company_bank_id" type="text" value="{{ ($errors->isEmpty()) ? $company->company_bank_id : old('company_bank_id') }}">

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
                            <textarea class="form-control @error('company_bank_account') is-invalid @enderror" id="company_bank_account" name="company_bank_account" rows="1" oninput="autoGrow(this);">{{ ($errors->isEmpty()) ? $company->company_bank_account : old('company_bank_account') }}</textarea>

                            @error('company_bank_account')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>                        

                        @if ($company->status == 1)
                        <div class="mb-3">
                            <button class="btn btn-danger px-5 w-100" type="button" onclick="lockConfirm();">凍結公司</button>
                        </div>
                        @elseif (! empty($company->company_id))
                        <div class="mb-3">
                            <button class="btn btn-success px-5 w-100" type="button" onclick="unlockConfirm();">解除凍結</button>
                        </div>
                        @endif

                        <div class="mb-5">
                            <button class="btn btn-primary px-5 w-100" type="button" onclick="fromSubmit();" @if(! empty($company->company_id) && $company->status != 1) disabled @endif>儲存</button>
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
            <div class="modal-body text-center">確定凍結此間公司嗎？</div>
            <div class="modal-footer justify-content-center">
                <button class="btn btn-danger untrigger" id="confirmDisableCompany" type="button">　是　</button>
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
                <button class="btn btn-success untrigger" id="confirmEnableCompany" type="button">　是　</button>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">　否　</button>
            </div>
        </div>
    </div>
</div>

@endsection
