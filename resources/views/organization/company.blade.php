@extends('layouts.app')

@section('content')

<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card-columns text-center">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title"><i class="bi bi-plus-circle-fill"></i></h5>
						<p class="card-text">新增公司</p>
					</div>
				</div>
				<div class="card col-sm-3">
					<div class="card-body">
						<h5 class="card-title"><i class="bi bi-building"></i></h5>
						<p class="card-text">公司列表</p>
					</div>
				</div>
				<div class="card col-sm-3">
					<div class="card-body">
						<h5 class="card-title"><i class="bi bi-shield-fill-check"></i></h5>
						<p class="card-text">待審查</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection