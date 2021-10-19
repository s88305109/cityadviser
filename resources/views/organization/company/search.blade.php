@extends('layouts.app')

@section('content')

<script>
	var page = 1;
	var end = false;
	var timers = null;

	$(document).ready(function() {
		$(window).scroll(function() {
			if (($(window).height() + $(window).scrollTop() + 200) >= $(document).height()) {
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

		$("form.search").submit(function() {
			if ($("input[name=keyword]").val() == "") {
				window.location.href = "/organization/company/{{ $first }}";
				return false;
			}

			window.location.href = "/organization/company/search/" + $("input[name=keyword]").val();
			return false;
		});
	});

	function loadMore(page) {
        $.ajax({
            type: "GET",
            url: "/organization/company/moreSearch/{{ $keyword }}",
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
			<h4><i class="bi bi-building"></i> 公司管理（公司搜尋）</h4>

			<form class="search" method="POST" action="/organization/company/search">
				@csrf
				
				<div class="input-group mb-2">
					<input type="text" class="form-control form-control skip-change-validate" name="keyword" value="{{ $keyword }}" placeholder="請輸入搜尋關鍵字">
					<button type="submit" class="input-group-text btn-primary rounded-end"><i class="bi bi-search me-2"></i>{{ __('搜尋') }}</button>
				</div>
			</form>

			<ol class="list-group">
				@include('organization.company.each')
			</ol>

			<div class="more-loading">
				<div class="spinner-border text-primary" role="status">
					<span class="visually-hidden">Loading...</span>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
