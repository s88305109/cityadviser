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
            url: "/organization/company/{{ $area }}/{{ $companyId }}/morePeople/{{ $state }}/" + page,
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
			<h4 class="text-center">{{ $company->company_name }}</h4>

			<ol class="list-group">
				@include('organization.company.people-each')
			</ol>

			<div class="more-loading">
				<div class="spinner-border text-primary" role="status">
					<span class="visually-hidden">Loading...</span>
				</div>
			</div>
		</div>

		<div class="btn-group bottom-tabs">
			<a class="btn btn-outline-primary @if ($state == 'left') active @endif" href="/organization/company/{{ $area }}/{{ $companyId }}/people/left">已離職</button>
			<a class="btn btn-outline-primary @if ($state != 'left') active @endif" href="/organization/company/{{ $area }}/{{ $companyId }}/people/on">在職中</a>
		</div>
	</div>
</div>

@endsection
