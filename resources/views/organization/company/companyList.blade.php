@extends('layouts.app')

@section('content')

<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8 mb-5">
			<h4><i class="bi bi-building"></i> 公司管理（公司列表）</h4>

			<ol class="list-group">
				@foreach ($companys as $row)
				<li class="list-group-item d-flex @if($row->status != 1) bg-light-red @endif">
					<div class="col-1 text-center">
						<span class="badge rounded-pill @if($row->status == 1) bg-primary @else bg-danger @endif">{{ $loop->iteration }}</span>
					</div>
					<div class="ms-3 me-auto fw-bold @if($row->status != 1) text-danger @endif">
						<a class="no-underline @if($row->status != 1) text-danger @endif" href="/organization/company/{{ substr(Route::currentRouteName(), 5) }}/{{ $row->company_id }}">
							{{ $row->company_name }}
						</a>
					</div>
				</li>
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
