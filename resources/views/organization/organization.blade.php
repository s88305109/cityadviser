@extends('layouts.app')

@section('content')

<script>
    $(document).ready(function () {
        $(".employee").click(function () {
            window.location.href = "/organization/employee";
        });

        $(".company").click(function () {
            window.location.href = "/organization/company";
        });
    });
</script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="row justify-content-center mt-2">
                <img src="/images/logo-128.png">
            </div>
            <h2 class="text-center mt-1">{{ config('app.name', '融鎰數位科技') }}</h2>

            <div class="card pt-3">
                <div class="card-body employee">
                    <h3><i class="bi bi-people-fill"></i> 員工管理</h3>
                </div>
            </div>

            <div class="card pt-3 text-right company">
                <div class="card-body">
                    <h3>公司管理 <i class="bi bi-building"></i></h3>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
