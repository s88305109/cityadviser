@extends('layouts.app')

@section('content')

<script>
	var page = 1;
	var end = false;
	var timers = null;

	$(document).ready(function() {
		$(window).scroll(function() {
			if (($(window).height() + $(window).scrollTop() + 150) >= $(document).height()) {
				clearTimeout(timers);
				timers = setTimeout(function() {
					if (end == false) {
						page++;
						loadMore(page);
					}
				}, 500);
			}
		});
	});

	function loadMore(page) {
		$(".more-loading").fadeIn();

        $.ajax({
            type: "GET",
            url: "/organization/company/moreCompany/{{ $area }}/" + page,
            dataType: "text",
            success: function (response) {
            	if (response == "") 
            		end = true;
            	else 
	                $("ol.list-group").append(response);

	            $(".more-loading").fadeOut();
            },
            error: function (thrownError) {
                showMessageModal(thrownError.responseJSON.message);
                $(".more-loading").fadeOut();
            }
        });
    }
</script>

<div class="container company-list list">
	<div class="row justify-content-center">
		<div class="col-md-8 list">
			<h4><i class="bi bi-building"></i> 公司管理（公司列表）</h4>

			<ol class="list-group">
				@include('organization.company.each')
			</ol>

			<div class="more-loading">
				<div class="spinner-border text-primary" role="status">
					<span class="visually-hidden">Loading...</span>
				</div>
			</div>
		</div>

		<div class="btn-group bottom-tabs">
			@foreach($areas as $value)
			<a class="btn btn-outline-primary @if ($area == $value) active @endif" href="/organization/company/{{ $value }}">{{ $value }}</a>
			@endforeach
		</div>
	</div>
</div>

@endsection
