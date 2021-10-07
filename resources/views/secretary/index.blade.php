@extends('layouts.app')

@section('content')

<script>
    var page = 1;
    var end = false;
    var timers = null;

    $(document).ready(function() {
        $(window).scroll(function() {
            if (($(window).height() + $(window).scrollTop() + 160) >= $(document).height()) {
                clearTimeout(timers);
                if (end == false) {
                    $(".more-loading").fadeIn();
                    timers = setTimeout(function() {
                            page++;
                            loadMore(page);
                    }, 500);
                }
            }
        });
    });

    function loadMore(page) {
        $.ajax({
            type: "GET",
            url: "/secretary/more/{{ $state }}/" + page,
            dataType: "text",
            success: function (response) {
                if (response == "") {
                    end = true;
                } else {
                    $(".toast-container").append(response);
                }

                $(".more-loading").fadeOut();
            },
            error: function (thrownError) {
                showMessageModal(thrownError.responseJSON.message);
                $(".more-loading").fadeOut();
            }
        });
    }

    function seen(id, obj) {
        objectShake(obj);

        $.ajax({
            type: "POST",
            url: "/secretary/watch",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: { id : id },
            dataType: "json",
            success: function (response) {
                $(obj).find(".rounded-circle").fadeOut();
                $(obj).prop("onclick", null).off("click");
                refreshUnread();
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

    function processAll() {
        window.location.href = "/secretary/processAll";
    }
</script>

<div class="container secretary">
    <div class="row justify-content-center">
        <div class="col-md-8 mb-2">
            <h4>
                <i class="bi bi-twitch fs-2"></i> 小秘書 
                @if($state == 'wait')
                <a class="btn btn-outline-secondary float-end" onclick="showConfirmModal('是否全部處理？', 'processAll();');">全部處理</a>
                @endif
            </h4>
        </div>

        <div class="clearfix"></div>

        <div class="toast-container">
            @include('secretary.each')
        </div>

        <div class="more-loading">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>

        <div class="mb-6em"></div>

        <div class="btn-group bottom-tabs">
            <a class="btn btn-outline-primary @if($state == 'processed') active @endif" href="/secretary/processed">已處理</a>
            <a class="btn btn-outline-primary @if($state == 'wait') active @endif" href="/secretary/wait">未處理</a>
        </div>
    </div>
</div>

@endsection
