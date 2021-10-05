@foreach ($users as $row)
<a class="no-underline @if($row->status != 1) text-danger @endif" href="/organization/employee/list/{{ $state }}/{{ $row->user_id }}">
	<li class="list-group-item d-flex @if($row->status != 1) bg-light-red @endif">
		<div class="col-1 text-center">
			<span class="badge rounded-pill @if($row->status == 1) bg-primary @else bg-danger @endif">{{ $loop->iteration + $offset }}</span>
		</div>
		<div class="ms-3 me-auto fw-bold @if($row->status != 1) text-danger @endif">{{ $row->name }}</div>
	</li>
</a>
@endforeach
