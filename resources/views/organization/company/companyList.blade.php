@extends('layouts.app')

@section('content')

<style>
	.badge.num-count{
		margin-top: -2.5em;
    	margin-right: -0.25em;
	}
</style>

<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8 mb-5">
			<h4><i class="bi bi-building"></i> 公司管理（公司列表）</h4>

			<ol class="list-group">
				@foreach ($companys as $row)
				<div class="card mb-1 bg-light">
					<div class="card-body py-2">
						<h4 class="card-title text-center">{{ $row->company_name }}</h4>
						<span class="badge bg-primary float-end rounded-circle num-count">{{ $row->count }}</span>
						<h6 class="card-subtitle mb-3 text-muted">
							<div class="input-group">
								<span class="input-group-text" id="basic-addon3">負責人</span>
								<input type="text" class="form-control" value="負責人">
							</div>
						</h6>
						<div class="text-center">
							<a class="btn btn-primary me-5" href="/organization/company/{{ substr(Route::currentRouteName(), 5) }}/{{ $row->company_id }}">編輯公司</a>
							<a class="btn btn-primary" href="#">員工列表</a>
						</div>
					</div>
				</div>
				@endforeach
			</ol>
		</div>

		<div class="btn-group bottom-tabs">
			<button type="button" class="btn btn-outline-primary @if (Route::currentRouteName() == 'auth.northList') active @endif" onclick="window.location.href='/organization/company/northList';">北部</button>
			<button type="button" class="btn btn-outline-primary @if (Route::currentRouteName() == 'auth.centralList') active @endif" onclick="window.location.href='/organization/company/centralList';">中部</button>
			<button type="button" class="btn btn-outline-primary @if (Route::currentRouteName() == 'auth.southList') active @endif" onclick="window.location.href='/organization/company/southList';">南部</button>
			<button type="button" class="btn btn-outline-primary @if (Route::currentRouteName() == 'auth.eastList') active @endif" onclick="window.location.href='/organization/company/eastList';">東部</button>
			<button type="button" class="btn btn-outline-primary @if (Route::currentRouteName() == 'auth.islandList') active @endif" onclick="window.location.href='/organization/company/islandList';">離島</button>
		</div>
	</div>
</div>

@endsection
