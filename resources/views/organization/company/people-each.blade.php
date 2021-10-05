@foreach ($users as $row)
<li class="list-group-item d-flex @if($row->status != 1) bg-light-red @endif">
	<div class="col-1 text-center">
		<span class="badge rounded-pill @if($row->status == 1) bg-primary @else bg-danger @endif">{{ $loop->iteration + $offset }}</span>
	</div>
	<div class="ms-3 me-auto fw-bold @if($row->status != 1) text-danger @endif">
		<a class="no-underline @if($row->status != 1) text-danger @endif" href="/organization/company/{{ $area }}/{{ $companyId }}/people/{{ $state }}/{{ $row->user_id }}">
			{{ $row->name }} 
			@if($row->user_id == $company->principal)
			<span class="badge bg-warning text-dark">負責人</span>
			@endif
		</a>
	</div>
</li>
@endforeach
