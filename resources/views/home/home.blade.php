@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="/css/splide/splide.min.css">
<script src="/js/splide/splide.min.js"></script>

<style>
    html, 
    body, 
    #app, 
    #main, 
    .splide, 
    .splide__track, 
    .splide__list, 
    .inner-page, 
    .inner-container  {
        height: calc(100% - 10px);
    }
    .splide__slide {
        margin-top: 1em;
        margin-bottom: 1em;
    }
    .splide__slide.is-active {
        margin-top: 0;
        margin-bottom: 0;
    }
    .inner-page .inner-container {
        height: calc(100% - 70px);
        padding: 1em;
        margin: 0.5em;
        border: 1px solid #CCC;
        border-radius: 16px;
        background-color: #F8F9FA;
    }
    .inner-container.sys01 { 
        background-color: #bff3ff; 
        border-color: #73E5FF; 
    }
    .inner-container.sys02 { 
        background-color: #ffc6bf; 
        border-color: #FF8373; 
    }
    .inner-container.sys03 { 
        background-color: #bfffc7; 
        border-color: #73FF83; 
    }
    .inner-container.organization { 
        background-color: #E1D5E7; 
        border-color: #CE92EC; 
    }
    .float-bar {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        font-size: 24px;
        padding: 4px;
        margin-top: 12px;
    }
    .float-bar span { display: none; }
</style>

<div class="container h-100">
    <div class="row justify-content-center h-100">
        <div class="col-md-6 px-0 h-100 splide position-relative">
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
                <span class="float-left"></span>
                <span class="float-right"></span>
            </div>
        </div>
    </div>
</div>

<script>
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
        $(".float-bar .float-left").html($(".splide__slide.is-active").prev().find(".inner-page h3 span").html()).show(100);
        $(".float-bar .float-right").html($(".splide__slide.is-active").next().find(".inner-page h3 span").html()).show(100);
        document.cookie = "pageIndex=" + splide.index;
        document.cookie = "pageBlock={{ $pageBlock }}";
    }).on('drag', function() {
        $(".float-bar .float-left").hide();
        $(".float-bar .float-right").hide();
    });
</script>

@endsection
