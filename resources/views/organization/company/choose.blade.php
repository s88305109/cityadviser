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

		@error('error')
        showMessageModal("{{ $message }}");
        @enderror
	});

	function loadMore(page) {
        $.ajax({
            type: "GET",
            url: "/organization/company/{{ $area }}/moreChoose/{{ $companyId }}/" + page,
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

    function check() {
    	if ($('input[name=choose]:checked').length == 0) {
    		showMessageModal('請選擇負責人');
    		return false;
    	}

    	showConfirmModal("確定要將" + $("input[name=choose]:checked").data("name") + "設定為負責人嗎？", "$('.setPrincipal').submit();")
    }
</script>

<div class="container list">
	<div class="row justify-content-center">
		<div class="col-md-8 list">
			<h4 class="text-center">{{ $company->company_name }}</h4>

			<form class="setPrincipal" action="/organization/company/setPrincipal" method="POST">
				@csrf

				<input type="hidden" name="companyId" value="{{ $companyId }}">

				<ol class="list-group">
					@include('organization.company.choose-each')
				</ol>
			</form>

			<div class="more-loading">
				<div class="spinner-border text-primary" role="status">
					<span class="visually-hidden">Loading...</span>
				</div>
			</div>
		</div>

		<div class="btn-group bottom-tabs">
			<a class="btn btn-outline-primary active" onclick="check()">設為負責人</a>
		</div>
	</div>
</div>

@endsection
