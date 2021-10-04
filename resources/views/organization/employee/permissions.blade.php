@extends('layouts.app')

@section('content')

<script>
    $(document).ready(function () {
        $("#saveBtn").click(function () {
            showLoadingMask();
            allowRedirect = true;
            $(".role").submit();
        });

        $(".card-header input").change(function() {
            if (! $(this).prop("checked"))
                $(this).parent().parent().parent().find("input").prop("checked", false);
        });

        $(".list-group input").change(function() {
            if ($(this).prop("checked"))
                $(this).parent().parent().parent().parent().find(".card-header input").prop("checked", true);
        });

        $("#job_id").change(function() {
            showLoadingMask();
            allowRedirect = true;
            window.location.href = "/organization/employee/permissions/" + $(this).find("option:selected").val();
        });
    });
</script>

<div class="container role-edit">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h4><i class="bi bi-list-task"></i> 員工管理（職位權限設定）</h4>
            <div class="card">
                <div class="card-body">
                    <form class="role" method="POST" action="/organization/employee/savePermissions" novalidate>
                        @csrf

                        <select class="form-select" id="job_id" name="job_id">
                            <option selected>請選擇職位</option>
                            @foreach($jobs as $row)
                            <option value="{{ $row->job_id }}" @if($jobId == $row->job_id) selected @endif>{{ ($row->type == 1) ? '總公司 - ' : '分公司 - ' }}{{ $row->job_title }}</option>
                            @endforeach
                        </select>

                        <div class="@if(empty($jobId)) d-none @endif">
                            <div class="p-3">
                                <div class="card">
                                    <div class="card-header fw-bold">
                                        <div class="form-check form-switch">
                                            <label class="form-check-label" for="organization">組織管理</label>
                                            <input class="form-check-input" type="checkbox" id="organization" name="role[]" value="organization" @if(isset($permission['organization'])) checked @endif>
                                        </div>
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <div class="form-check form-switch">
                                                <label class="form-check-label" for="employee">員工管理</label>
                                                <input class="form-check-input" type="checkbox" id="employee" name="role[]" value="employee" @if(isset($permission['employee'])) checked @endif>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="form-check form-switch">
                                                <label class="form-check-label" for="company">公司管理</label>
                                                <input class="form-check-input" type="checkbox" id="company" name="role[]" value="company" @if(isset($permission['company'])) checked @endif>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="p-3">
                                <div class="card">
                                    <div class="card-header fw-bold">
                                        <div class="form-check form-switch">
                                            <label class="form-check-label" for="case">報件管理</label>
                                            <input class="form-check-input" type="checkbox" id="case" name="role[]" value="case" @if(isset($permission['case'])) checked @endif>
                                        </div>
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <div class="form-check form-switch">
                                                <label class="form-check-label" for="present">案件報件</label>
                                                <input class="form-check-input" type="checkbox" id="present" name="role[]" value="present" @if(isset($permission['present'])) checked @endif>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="p-3">
                                <div class="card">
                                    <div class="card-header fw-bold">
                                        <div class="form-check form-switch">
                                            <label class="form-check-label" for="review">報件審查</label>
                                            <input class="form-check-input" type="checkbox" id="review" name="role[]" value="review" @if(isset($permission['review'])) checked @endif>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="p-3">
                                <div class="card">
                                    <div class="card-header fw-bold">
                                        <div class="form-check form-switch">
                                            <label class="form-check-label" for="staff">員工管理</label>
                                            <input class="form-check-input" type="checkbox" id="staff" name="role[]" value="staff" @if(isset($permission['staff'])) checked @endif>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="mb-5">
                                <button type="button" class="btn btn-primary px-5 w-100" id="saveBtn">儲存</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
