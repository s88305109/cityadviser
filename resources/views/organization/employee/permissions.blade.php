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
                            <option value="" selected>請選擇職位</option>
                            @foreach($jobs as $row)
                            <option value="{{ $row->job_id }}" @if($jobId == $row->job_id) selected @endif>{{ ($row->type == 1) ? '總公司 - ' : '分公司 - ' }}{{ $row->job_title }}</option>
                            @endforeach
                        </select>

                        @foreach($roles as $key => $rows)
                        <div class="p-3">
                            <div class="card">
                                <div class="card-header fw-bold">
                                    <div class="form-check form-switch">
                                        <label class="form-check-label" for="{{ $key }}">{{ $rows['title'] }}</label>
                                        <input class="form-check-input" type="checkbox" id="{{ $key }}" name="role[]" value="{{ $key }}" @if(isset($permission[$key])) checked @endif>
                                    </div>
                                </div>
                                @if(isset($rows['child']))
                                <ul class="list-group list-group-flush">
                                    @foreach($rows['child'] as $cKey => $cRows)
                                    <li class="list-group-item">
                                        <div class="form-check form-switch">
                                            <label class="form-check-label" for="{{ $cKey }}">{{ $cRows['title'] }}</label>
                                            <input class="form-check-input" type="checkbox" id="{{ $cKey }}" name="role[]" value="{{ $cKey }}" @if(isset($permission[$cKey])) checked @endif>
                                        </div>
                                    </li>
                                    
                                        @if(isset($cRows['child']))
                                            @foreach($cRows['child'] as $c2Key => $c2Rows)
                                            <li class="list-group-item">
                                                <div class="form-check form-switch triple">
                                                    <label class="form-check-label" for="{{ $c2Key }}">{{ $c2Rows['title'] }}</label>
                                                    <input class="form-check-input" type="checkbox" id="{{ $c2Key }}" name="role[]" value="{{ $c2Key }}" @if(isset($permission[$c2Key])) checked @endif>
                                                </div>
                                            </li>
                                            @endforeach
                                        @endif

                                    @endforeach
                                </ul>
                                @endif
                            </div>
                        </div>
                        @endforeach

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
