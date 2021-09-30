@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="row justify-content-center mt-2">
                <img class="logo128" src="/images/logo-128.png">
            </div>
            <h2 class="text-center mt-1">{{ config('app.name', '融鎰數位科技') }}</h2>

            @if(Auth::user()->hasPermission('employee'))
            <div class="card pt-3">
                <a href="/organization/employee">
                    <div class="card-body employee">
                        <h3><i class="bi bi-people-fill"></i> 員工管理</h3>
                    </div>
                </a>
            </div>
            @endif

            @if(Auth::user()->hasPermission('company'))
            <div class="card pt-3 text-end company">
                <a href="/organization/company">
                    <div class="card-body">
                        <h3>公司管理 <i class="bi bi-building"></i></h3>
                    </div>
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection
