@extends('layouts.app')

@section('content')

<script>
    $(document).ready(function () {
        $(".information").click(function () {
            window.location.href = "/user/information";
        });

        $(".logout").click(function () {
            $("#logoutConfirm").modal("show");
        });

        $(".doLogout").click(function () {
            window.location.href = "/logout";
        });
    });
</script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="row justify-content-center mt-2">
                <img class="logo128" src="/images/logo-128.png">
            </div>
            <h2 class="text-center mt-1">{{ config('app.name', '融鎰數位科技') }}</h2>

            <div class="card pt-3">
                <div class="card-body information">
                    <h3><i class="bi bi-person-lines-fill"></i> 個人資料</h3>
                </div>
            </div>

            <div class="card pt-3 text-right logout">
                <div class="card-body">
                    <h3><i class="bi bi-door-closed-fill"></i> 登出系統</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="logoutConfirm" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                確定登出？
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-primary doLogout">　是　</button>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">　否　</button>
            </div>
        </div>
    </div>
</div>

@endsection
