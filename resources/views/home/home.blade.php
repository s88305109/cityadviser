@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="/css/splide/splide.min.css">
<script src="/js/splide/splide.min.js"></script>

<style>
    html, body, #app, #main, .splide, .splide__track, .splide__list, .inner-page, .inner-container  {
        height: calc(100% - 10px);
    }
    .inner-page h2 {
        text-align: center;
        margin-top: 0.5em;
    }
    .inner-page .inner-container {
        height: calc(100% - 74px);
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
    .inner-container.sys04 { 
        background-color: #E1D5E7; 
        border-color: #CE92EC; 
    }
</style>

<div class="container h-100">
    <div class="row justify-content-center h-100">
        <div class="col-md-6 px-0 h-100">
            <div class="splide h-100">
                <div class="splide__track">
                    <ul class="splide__list">
                        @foreach ($sysList as $key => $data)
                        <li class="splide__slide">
                            <div class="inner-page">
                                <h2 class="mt-0">{!! $data['icon'] !!} {{ $data['title'] }}</h2>
                                <div class="inner-container {{ $key }}">Content</div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var splide = new Splide( '.splide', {
        type : 'loop',
        padding: {
            right : '3rem',
            left : '3rem',
        },
        pagination : false,
        arrows : false,
    }).mount();

    /*
    console.log( splide.index ); // 0
    splide.go('3'); 
    console.log( splide.index ); // 1
    */
</script>
@endsection
