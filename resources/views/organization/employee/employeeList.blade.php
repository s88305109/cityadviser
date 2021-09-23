@extends('layouts.app')

@section('content')

<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8 mb-5">
			<h4><i class="bi bi-person-lines-fill"></i> 員工管理（員工列表）</h4>

			<ol class="list-group">
				@foreach ($users as $row)
				<li class="list-group-item d-flex">
					<div class="col-1 text-center">
						<span class="badge bg-primary rounded-pill">{{ $loop->iteration }}</span>
					</div>
					<div class="ms-3 me-auto fw-bold">
						<a class="no-underline" href="/organization/employee/employeeList/{{ $row->user_id }}">
							{{ $row->name }}
						</a>
					</div>
				</li>
				@endforeach
			</ol>
		</div>

		<div class="btn-group bottom-tabs">
			<button type="button" class="btn btn-outline-primary" onclick="window.location.href='/organization/employee/leaversList';">已離職</button>
			<button type="button" class="btn btn-outline-primary active">在職中</button>
		</div>
	</div>
</div>

@endsection
