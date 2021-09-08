@extends('layouts.app')

@section('content')

<script type="text/javascript">
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
                <img src="/images/logo-128.png">
            </div>
            <h2 class="text-center mt-1">{{ config('app.name', '融鎰數位科技') }}</h2>

            <div class="card pt-3 pb-3">
                <div class="card-body information"><strong>個人資料</strong></div>
            </div>

            <div class="card pt-3 pb-3 text-right logout">
                <div class="card-body"><strong>登出系統</strong></div>
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
                <button type="button" class="btn btn-secondary" data-dismiss="modal">　否　</button>
            </div>
        </div>
    </div>
</div>

@endsection
