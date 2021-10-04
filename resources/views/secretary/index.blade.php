@extends('layouts.app')

@section('content')

<script>
    function seen(id, obj) {
        $.ajax({
            type: "POST",
            url: "/secretary/watch",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: { id : id },
            dataType: "json",
            success: function (response) {
                $(obj).find(".rounded-circle").fadeOut();
                $(obj).prop("onclick", null).off("click");
            },
            error: function (thrownError) {
                if (thrownError.status == "419") {
                    $("#user_number").parent().find("span.invalid-feedback").remove();
                    showMessageModal("{{ __('頁面閒置過久請重新整理網頁') }}");
                } else {
                    showMessageModal(thrownError.responseJSON.message);
                }
            }
        });
    }
</script>

<div class="container secretary">
    <div class="row justify-content-center">
        <div class="col-md-8 mb-2">
            <h4><i class="bi bi-twitch fs-2"></i> 小秘書 <a class="btn btn-outline-secondary float-end" href="#">全部處理</a></h4>
        </div>

        <div class="clearfix"></div>

        <div class="toast-container">
            @foreach($events as $row)
            <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true" @if($row->watch == 0) onclick="seen('{{ $row->id }}', this);" @endif>
                <div class="toast-header">
                    <svg class="bd-placeholder-img rounded me-2" width="20" height="20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="#007aff"></rect></svg>
                    <strong class="me-auto">{{ $row->event }}</strong>
                    <small>{{ $row->deadline }}</small>
                    
                    @if($row->watch == 0)
                    <span class="p-2 bg-danger rounded-circle">
                        <span class="visually-hidden">alert</span>
                    </span>
                    @endif
                </div>
                <div class="toast-body">{{ $row->content }}</div>
            </div>
            @endforeach
        </div>

        <div class="btn-group bottom-tabs">
            <a class="btn btn-outline-primary @if ($state == 'processed') active @endif" href="/secretary/processed">已處理</a>
            <a class="btn btn-outline-primary @if ($state == 'wait') active @endif" href="/secretary/wait">未處理</a>
        </div>
    </div>
</div>

@endsection
