@extends('layouts.app')

@section('content')

<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8 mb-5">
			<h4><i class="bi bi-person-lines-fill"></i> 員工管理（員工列表）</h4>

			<ol class="list-group">
				@foreach ($users as $row)
				<li class="list-group-item d-flex @if($row->status != 1) bg-light-red @endif">
					<div class="col-1 text-center">
						<span class="badge rounded-pill @if($row->status == 1) bg-primary @else bg-danger @endif">{{ $loop->iteration }}</span>
					</div>
					<div class="ms-3 me-auto fw-bold @if($row->status != 1) text-danger @endif">
						<a class="no-underline @if($row->status != 1) text-danger @endif" href="/organization/employee/{{ substr(Route::currentRouteName(), 5) }}/{{ $row->user_id }}">
							{{ $row->name }}
						</a>
					</div>
				</li>
				@endforeach
			</ol>
		</div>

		<div class="btn-group bottom-tabs">
			<button type="button" class="btn btn-outline-primary @if (Route::currentRouteName() == 'auth.leaversList') active @endif" onclick="window.location.href='/organization/employee/leaversList';">已離職</button>
			<button type="button" class="btn btn-outline-primary @if (Route::currentRouteName() == 'auth.employeeList') active @endif" onclick="window.location.href='/organization/employee/employeeList';">在職中</button>
		</div>
	</div>
</div>

@endsection
