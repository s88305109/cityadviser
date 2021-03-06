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

        $(".list-group.child input").change(function() {
            if ($(this).prop("checked")) {
                $("#" + $(this).data("parent")).prop("checked", true);
                
                if ($("#" + $(this).data("parent")).data("parent") != "undefined" && $("#" + $(this).data("parent")).data("parent") !== null)
                    $("#" + $("#" + $(this).data("parent")).data("parent")).prop("checked", true);
            } else {
                if ($("input[name=role\\[\\]][data-parent=" + $(this).data("parent") + "]:checked").length == 0)
                    $("#" + $(this).data("parent")).prop("checked", false);

                if ($("#" + $(this).data("parent")).data("parent") != "undefined" && $("#" + $(this).data("parent")).data("parent") !== null)
                    if ($("input[name=role\\[\\]][data-parent=" + $("#" + $(this).data("parent")).data("parent") + "]:checked").length == 0)
                        $("#" + $("#" + $(this).data("parent")).data("parent")).prop("checked", false);

                $("input[name=role\\[\\]][data-parent=" + $(this).val() + "]:checked").prop("checked", false);
            }
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
                                        <label class="form-check-label" for="{{ $rows->role }}">{{ $rows->title }}</label>
                                        <input class="form-check-input" type="checkbox" id="{{ $rows->role }}" name="role[]" value="{{ $rows->role }}" {{ isset($permission[$rows->role]) ? 'checked' : '' }}>
                                    </div>
                                </div>
                                @if(isset($rows['child']))
                                <ul class="list-group list-group-flush child">
                                    @foreach($rows['child'] as $cKey => $cRows)
                                    <li class="list-group-item">
                                        <div class="form-check form-switch">
                                            <label class="form-check-label" for="{{ $cRows->role }}">{{ $cRows->title }}</label>
                                            <input class="form-check-input" type="checkbox" id="{{ $cRows->role }}" name="role[]" value="{{ $cRows->role }}" data-parent="{{ $rows->role }}" {{ isset($permission[$cRows->role]) ? 'checked' : '' }}>
                                        </div>
                                    </li>
                                    
                                        @if(isset($cRows['child']))
                                            @foreach($cRows['child'] as $c2Key => $c2Rows)
                                            <li class="list-group-item grandson">
                                                <div class="form-check form-switch">
                                                    <label class="form-check-label" for="{{ $c2Rows->role }}">{{ $c2Rows->title }}</label>
                                                    <input class="form-check-input" type="checkbox" id="{{ $c2Rows->role }}" name="role[]" value="{{ $c2Rows->role }}" data-parent="{{ $cRows->role }}" {{ isset($permission[$c2Rows->role]) ? 'checked' : '' }}>
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
