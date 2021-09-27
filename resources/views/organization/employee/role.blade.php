@extends('layouts.app')

@section('content')

<script>
    $(document).ready(function () {
        $("#saveBtn").click(function () {
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
    });
</script>

<style>
.list-group-item .form-switch { padding-left: 3.5em; }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h4><i class="bi bi-list-task"></i> 員工管理（客製化權限）</h4>
            <div class="card">
                <div class="card-body">
                    <form class="role" method="POST" action="/organization/employee/saveRole" novalidate>
                        @csrf

                        <input type="hidden" name="user_id" value="{{ $user->user_id }}">
                        <input type="hidden" name="routeName" value="{{ Route::currentRouteName() }}">

                        <div class="p-3">
                            <div class="card">
                                <div class="card-header fw-bold">
                                    <div class="form-check form-switch">
                                        <label class="form-check-label" for="m.organization">組織管理</label>
                                        <input class="form-check-input" type="checkbox" id="m.organization" name="role[]" value="m.organization" @if(isset($permission['m.organization'])) checked @endif>
                                    </div>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <div class="form-check form-switch">
                                            <label class="form-check-label" for="m.employee">員工管理</label>
                                            <input class="form-check-input" type="checkbox" id="m.employee" name="role[]" value="m.employee" @if(isset($permission['m.employee'])) checked @endif>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="form-check form-switch">
                                            <label class="form-check-label" for="m.company">公司管理</label>
                                            <input class="form-check-input" type="checkbox" id="m.company" name="role[]" value="m.company" @if(isset($permission['m.company'])) checked @endif>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="p-3">
                            <div class="card">
                                <div class="card-header fw-bold">
                                    <div class="form-check form-switch">
                                        <label class="form-check-label" for="m.case">報件管理</label>
                                        <input class="form-check-input" type="checkbox" id="m.case" name="role[]" value="m.case" @if(isset($permission['m.case'])) checked @endif>
                                    </div>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <div class="form-check form-switch">
                                            <label class="form-check-label" for="m.present">案件報件</label>
                                            <input class="form-check-input" type="checkbox" id="m.present" name="role[]" value="m.present" @if(isset($permission['m.present'])) checked @endif>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="form-check form-switch">
                                            <label class="form-check-label" for="m.review">報件審查</label>
                                            <input class="form-check-input" type="checkbox" id="m.review" name="role[]" value="m.review" @if(isset($permission['m.review'])) checked @endif>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <hr>

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
