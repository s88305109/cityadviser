@extends('layouts.app')

@section('content')

<script>
	var page = 1;
	var end = false;
	var timers = null;

	$(document).ready(function() {
		$(window).scroll(function() {
			if (($(window).height() + $(window).scrollTop() + 120) >= $(document).height()) {
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
            url: "/organization/employee/moreEmployee/{{ $state }}/" + page,
            dataType: "text",
            success: function (response) {
            	if (response == "") {
            		end = true;
            	} else {
	                $("ol.list-group").append(response);
	            }

	            $(".more-loading").fadeOut();
            },
            error: function (thrownError) {
                showMessageModal(thrownError.responseJSON.message);
                $(".more-loading").fadeOut();
            }
        });
    }
</script>

<div class="container list">
	<div class="row justify-content-center">
		<div class="col-md-8 list">
			<h4><i class="bi bi-person-lines-fill"></i> 員工管理（員工列表）</h4>

			<ol class="list-group">
				@include('organization.employee.each')
			</ol>

			<div class="more-loading">
				<div class="spinner-border text-primary" role="status">
					<span class="visually-hidden">Loading...</span>
				</div>
			</div>
		</div>

		<div class="btn-group bottom-tabs">
			<a class="btn btn-outline-primary @if ($state == 'left') active @endif" href="/organization/employee/list/left">已離職</a>
			<a class="btn btn-outline-primary @if ($state != 'left') active @endif" href="/organization/employee/list/on">在職中</a>
		</div>
	</div>
</div>

@endsection
