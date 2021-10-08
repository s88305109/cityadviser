@foreach ($users as $row)
<li class="list-group-item d-flex @if($row->status != 1) bg-light-red @endif">
	<div class="col-1 text-center">
		<span class="badge rounded-pill @if($row->status == 1) bg-primary @else bg-danger @endif">{{ $loop->iteration + $offset }}</span>
	</div>
	
	<div class="ms-3 w-100 fw-bold @if($row->status != 1) text-danger @endif">
		{{ $row->name }} 
		<input class="form-check-input float-end" type="radio" name="choose" value="{{ $row->user_id }}" data-name="{{ $row->name }}">
	</div>
</li>
@endforeach
