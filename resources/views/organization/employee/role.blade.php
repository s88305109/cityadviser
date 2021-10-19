@extends('layouts.app')

@section('content')

<script>
    $(document).ready(function () {
        $("#saveBtn").click(function () {
            showLoadingMask();
            allowRedirect = true;
            $(".role").submit();
        });

        $("#role_custom").change(function() {
            if (! $(this).prop("checked"))
                $(".card-body input").prop("disabled", true);
            else
                $(".card-body input").prop("disabled", false);
        });

        $(".card-body .card-header input").change(function() {
            if (! $(this).prop("checked"))
                $(this).parent().parent().parent().find("input").prop("checked", false);
        });

        $(".card-body .list-group.child input").change(function() {
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

        {!! $user->role_custom ? '' : '$(".card-body input").prop("disabled", true);' !!}
    });
</script>

<div class="container role-edit">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h4><i class="bi bi-list-task"></i> 客製化權限（{{ $user->name }}）</h4>
            <form class="role" method="POST" action="/organization/employee/saveRole" novalidate>
                @csrf
                <input type="hidden" name="user_id" value="{{ $user->user_id }}">
                <input type="hidden" name="state" value="{{ $state }}">

                <div class="card">
                    <div class="card-header">
                        <div class="form-check form-switch">
                            <input class="form-check-input" id="role_custom" name="role_custom" type="checkbox" role="switch" value="1" {{ $user->role_custom ? 'checked' : '' }}>
                            <label class="form-check-label" for="role_custom">啟用客製化權限</label>
                        </div>
                    </div>
                    <div class="card-body">
                        @foreach($roles as $key => $rows)
                        <div class="p-3">
                            <div class="card">
                                <div class="card-header fw-bold">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="{{ $rows->role }}" name="role[]" value="{{ $rows->role }}" @if(isset($permission[$rows->role])) 
                                        checked @endif>
                                        <label class="form-check-label" for="{{ $rows->role }}">{{ $rows->title }}</label>
                                    </div>
                                </div>
                                @if(isset($rows['child']))
                                <ul class="list-group list-group-flush child">
                                    @foreach($rows['child'] as $cKey => $cRows)
                                    <li class="list-group-item">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="{{ $cRows->role }}" name="role[]" value="{{ $cRows->role }}" data-parent="{{ $rows->role }}" {{ isset($permission[$cRows->role]) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="{{ $cRows->role }}">{{ $cRows->title }}</label>
                                        </div>
                                    </li>

                                        @if(isset($cRows['child']))
                                            @foreach($cRows['child'] as $c2Key => $c2Rows)
                                            <li class="list-group-item grandson">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="{{ $c2Rows->role }}" name="role[]" value="{{ $c2Rows->role }}" data-parent="{{ $cRows->role }}" {{ isset($permission[$c2Rows->role]) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="{{ $c2Rows->role }}">{{ $c2Rows->title }}</label>
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
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
