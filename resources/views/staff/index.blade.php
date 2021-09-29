@extends('layouts.app')

@section('content')

<div class="container block-inner-page">
    <div class="row justify-content-center">
        <div class="col-md-8 card-columns text-center">
            <div class="card py-3">
                <a href="/staff/new">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-person-plus-fill"></i></h5>
                        <p class="card-text">新增員工</p>
                    </div>
                </a>
            </div>
            <div class="card py-3 mt-3">
                <a href="/staff/on">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-person-lines-fill"></i></h5>
                        <p class="card-text">員工列表</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
