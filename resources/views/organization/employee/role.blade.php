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
    });
</script>

<div class="container role-edit">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h4><i class="bi bi-list-task"></i> 員工管理（客製化權限）</h4>
            <div class="card">
                <div class="card-body">
                    <form class="role" method="POST" action="/organization/employee/saveRole" novalidate>
                        @csrf

                        <input type="hidden" name="user_id" value="{{ $user->user_id }}">
                        <input type="hidden" name="state" value="{{ $state }}">

                        @foreach($roles as $key => $rows)
                        <div class="p-3">
                            <div class="card">
                                <div class="card-header fw-bold">
                                    <div class="form-check form-switch">
                                        <label class="form-check-label" for="{{ $rows->role }}">{{ $rows->title }}</label>
                                        <input class="form-check-input" type="checkbox" id="{{ $rows->role }}" name="role[]" value="{{ $rows->role }}" @if(isset($permission[$rows->role])) checked @endif>
                                    </div>
                                </div>
                                @if(isset($rows['child']))
                                <ul class="list-group list-group-flush">
                                    @foreach($rows['child'] as $cKey => $cRows)
                                    <li class="list-group-item">
                                        <div class="form-check form-switch">
                                            <label class="form-check-label" for="{{ $cRows->role }}">{{ $cRows->title }}</label>
                                            <input class="form-check-input" type="checkbox" id="{{ $cRows->role }}" name="role[]" value="{{ $cRows->role }}" @if(isset($permission[$cRows->role])) checked @endif>
                                        </div>
                                    </li>

                                        @if(isset($cRows['child']))
                                            @foreach($cRows['child'] as $c2Key => $c2Rows)
                                            <li class="list-group-item">
                                                <div class="form-check form-switch triple">
                                                    <label class="form-check-label" for="{{ $c2Rows->role }}">{{ $c2Rows->title }}</label>
                                                    <input class="form-check-input" type="checkbox" id="{{ $c2Rows->role }}" name="role[]" value="{{ $c2Rows->role }}" @if(isset($permission[$c2Rows->role])) checked @endif>
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
