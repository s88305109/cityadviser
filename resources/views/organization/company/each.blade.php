@foreach ($companys as $row)
<div class="card mb-1 @if($row->status != 1) bg-light-red @else bg-light @endif">
	<div class="card-body py-2">
		<h4 class="card-title text-center">{{ $row->company_name }}</h4>
		<span class="badge bg-primary float-end rounded-circle num-count">{{ $row->count }}</span>
		<h6 class="card-subtitle mb-3 text-muted">
			<div class="input-group">
				<span class="input-group-text" id="basic-addon3">負責人</span>
				<input type="text" class="form-control" value="{{ $row->principal_name }}">
			</div>
		</h6>
		<div class="text-center">
			<a class="btn btn-primary me-5" href="/organization/company/{{ $area }}/{{ $row->company_id }}">編輯公司</a>
			<a class="btn btn-primary" href="/organization/company/{{ $area }}/{{ $row->company_id }}/people/on">員工列表</a>
		</div>
	</div>
</div>
@endforeach
