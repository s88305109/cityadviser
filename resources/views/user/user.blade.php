@extends('layouts.app')

@section('content')

<script>
    function logout() {
        window.location.href = "/logout";
    }
</script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="row justify-content-center mt-2">
                <img class="logo128" src="/images/logo-128.png">
            </div>
            <h2 class="text-center mt-1">{{ config('app.name', '融鎰數位科技') }}</h2>

            <div class="card pt-3">
                <a href="/user/information">
                    <div class="card-body information">
                        <h3><i class="bi bi-person-lines-fill"></i> 個人資料</h3>
                    </div>
                </a>
            </div>

            <div class="card pt-3 text-end logout">
                <a href="#" onclick="showConfirmModal('確定登出？', 'logout();');">
                    <div class="card-body">
                        <h3><i class="bi bi-door-open-fill"></i> 登出系統</h3>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
