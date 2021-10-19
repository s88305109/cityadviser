@foreach ($companys as $row)
<div class="card mb-1 @if($row->status != 1) bg-light-red @else bg-light @endif">
	<div class="card-body py-2">
		<h4 class="card-title text-center">{{ $row->company_name }}</h4>
		<span class="badge bg-primary float-end rounded-circle num-count">{{ $row->count }}</span>
		<h6 class="card-subtitle mb-3 text-muted">
			<div class="input-group">
				<span class="input-group-text" id="basic-addon3">負責人</span>
				
				@if(empty($row->principal))
				<div class="form-control">
					<a class="float-start" href="/organization/company/{{ $row->area }}/addPerson/{{ $row->company_id }}">點我新增負責人</a>
					<a class="float-end" href="/organization/company/{{ $row->area }}/choose/{{ $row->company_id }}">員工列表</a>
				</div>
				@else
				<div class="form-control">{{ $row->principal_name }}</div>
				@endif
			</div>
		</h6>
		<div class="text-center">
			<a class="btn btn-primary me-5" href="/organization/company/{{ $row->area }}/{{ $row->company_id }}{{ isset($keyword) ? '/search/'.$keyword : '' }}">編輯公司</a>
			<a class="btn btn-primary" href="/organization/company/{{ $row->area }}/{{ $row->company_id }}/people/on{{ isset($keyword) ? '/search/'.$keyword : '' }}">員工列表</a>
		</div>
	</div>
</div>
@endforeach
