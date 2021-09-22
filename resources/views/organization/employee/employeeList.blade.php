@extends('layouts.app')

@section('content')

<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8 mb-5">
			<h4><i class="bi bi-person-lines-fill"></i> 員工管理（員工列表）</h4>

			<ul class="list-group">
				@foreach ($users as $row)
				<li class="list-group-item">{{ $row->name }}</li>
				@endforeach
			</ul>
		</div>
	</div>
</div>

@endsection
