@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="/css/splide/splide.min.css">
<script src="/js/splide/splide.min.js"></script>

<style>
    html, 
    body{ height: calc(100% - 48px); }
    #app, 
    #main, 
    .splide, 
    .splide__list, 
    .splide__track,
    .inner-page, 
    .inner-container{ height: 100% }
    .splide__slide {
        margin-top: 1em;
        margin-bottom: 1em;
    }
    .splide__slide.is-active {
        margin-top: 0;
        margin-bottom: 0;
    }
    .inner-page .inner-container {
        height: calc(100% - 40px);
        padding: 1em;
        margin: 0.5em;
        border: 1px solid #CCC;
        border-radius: 16px;
        background-color: #F8F9FA;
    }
    .float-bar {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        margin-top: 8px;
        padding: 4px;
        font-size: 24px;
    }
    .float-bar span { display: none; }
    .start-shadow,
    .end-shadow {
        position: absolute;
        top: calc(50% - 100px);
        z-index: 20;
        height: 200px;
        width: 20px;
        background: radial-gradient(at center, rgba(0,0,0,.5),transparent 50%) no-repeat;
        background-size: 18px 100%;
        animation: wheel 2s infinite;
        opacity: 1;
    }
    @keyframes wheel {
        50% { opacity: 0.5; }
        100% { opacity: 1; }
    }
    .start-shadow{ 
        left: 0; 
        background-position: -6px;
    }
    .end-shadow{ 
        right: 0;
        background-position: 6px;
    }
</style>

<div class="container h-100">
    <div class="row justify-content-center h-100">
        <div class="col-md-6 px-0 splide position-relative">
            <div class="splide__track">
                <ul class="splide__list">
                    @foreach ($sysList as $key => $data)
                    <li class="splide__slide">
                        <div class="inner-page">
                            <h3 class="mt-0 text-center"><span>{!! $data['icon'] !!}</span> {{ $data['title'] }}</h3>
                            <div class="inner-container {{ $key }}">
                                @includeIf("home.block.$key")
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>

            <div class="float-bar">
                <span class="float-start"></span>
                <span class="float-end"></span>
            </div>

            <div class="start-shadow"></div>
            <div class="end-shadow"></div>
        </div>
    </div>
</div>


<script>
    function getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
    }
    
    const pageIndex = (getCookie("pageIndex") == null | getCookie("pageBlock") != "{{ $pageBlock }}") ? 0 : getCookie("pageIndex");
    const splide = new Splide(".splide", {
        type: "loop",
        padding: {
            right: "3rem",
            left: "3rem",
        },
        pagination: false,
        arrows: false,
        start: pageIndex,
    }).mount();

    splide.on('active', function() {
        $(".float-bar .float-start").html($(".splide__slide.is-active").prev().find(".inner-page h3 span").html()).show(100);
        $(".float-bar .float-end").html($(".splide__slide.is-active").next().find(".inner-page h3 span").html()).show(100);
        document.cookie = "pageIndex=" + splide.index;
        document.cookie = "pageBlock={{ $pageBlock }}";
    }).on('drag', function() {
        $(".float-bar .float-start").hide();
        $(".float-bar .float-end").hide();
    });
</script>

@endsection
