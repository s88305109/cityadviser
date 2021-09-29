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
						<a class="no-underline @if($row->status != 1) text-danger @endif" href="/staff/{{ $state }}/{{ $row->user_id }}">
							{{ $row->name }}
						</a>
					</div>
				</li>
				@endforeach
			</ol>
		</div>

		<div class="btn-group bottom-tabs">
			<a class="btn btn-outline-primary @if ($state == 'left') active @endif" href="/staff/left">已離職</a>
			<a class="btn btn-outline-primary @if ($state != 'left') active @endif" href="/staff/on">在職中</a>
		</div>
	</div>
</div>

@endsection
