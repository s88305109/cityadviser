@extends('layouts.app')

@section('content')

<div class="container block-inner-page">
	<div class="row justify-content-center">
		<div class="col-md-8 card-columns text-center">
			<div class="card py-3">
				<a href="/organization/company/newCompany">
					<div class="card-body">
						<h5 class="card-title"><i class="bi bi-plus-circle-fill"></i></h5>
						<p class="card-text">新增公司</p>
					</div>
				</a>
			</div>
			<div class="card py-3 d-inline-block two-column mt-3 me-2">
				<a href="/organization/company/northList">
					<div class="card-body">
						<h5 class="card-title"><i class="bi bi-building"></i></h5>
						<p class="card-text">公司列表</p>
					</div>
				</a>
			</div>
			<div class="card py-3 d-inline-block two-column">
				<div class="card-body">
					<h5 class="card-title"><i class="bi bi-shield-fill-check"></i></h5>
					<p class="card-text">待審查</p>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
