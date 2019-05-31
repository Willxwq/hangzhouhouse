<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>杭州</title>
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/realEstate/css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/menu/meny.css?time=1') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/realEstate/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/realEstate/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/realEstate/css/admin.min.css') }}">
    @yield('css')
</head>
<body>
<style>
    body {
        background-color : #eaf0f4;
    }
    .card-bodyh {
        height: 430px;
    }
    .inputSty {
        width: 35px;
        height: 18px;
        text-align: center;
    }
    .m-filter {
        width: 1100px;
        margin: 0 auto;
        margin-top: 26px;
        padding: 25px;
        padding-bottom: 14px;
        padding-top: 14px;
        background-color: #fbfbfb;
        box-shadow: 0 1px 2px -1px rgba(0,0,0,0.2);
        font-size: 12px;
        line-height: 1;
        position: relative;
    }
    dl, dt, dd, ul, ol, li {
        list-style: none;
        margin: 0;
        padding: 0;
    }
    dl {
        display: block;
        margin-block-start: 1em;
        margin-block-end: 1em;
        margin-inline-start: 0px;
        margin-inline-end: 0px;
    }
    .m-filter dl {
        overflow: hidden;
    }
    .m-filter dt {
        float: left;
        width: 4.5%;
        font-weight: 700;
        line-height: 27px;
    }
    .header .search {
        width: 1150px;
        margin: 0 auto;
        margin-top: 25px;
    }
    .header .search .input input {
        vertical-align: top;
        box-sizing: border-box;
        width: 710px;
        height: 45px;
        line-height: 45px;
        padding: 0 22px;
        border: 0;
        box-shadow: 0 1px 2px -1px rgba(0,0,0,0.2);
        border-radius: 2px;
    }
    input, textarea, button {
        margin: 0;
        padding: 0;
        outline: none;
        resize: none;
        font-family: "Hiragino Sans GB","Microsoft Yahei UI","Microsoft Yahei","微软雅黑",'Segoe UI',Tahoma,"宋体b8b\4f53",SimSun,sans-serif;
    }
    .header {
        background-color: #f5f5f6;
        line-height: 1;
        padding: 30px 0 26px;
    }
    .header .search .input .inputRightPart .searchButton {
        cursor: pointer;
        width: 50px;
        height: 45px;
        display: inline-block;
        text-align: center;
        background-color: #fff;
    }
    .header .search .input .inputRightPart .searchButton i {
        display: inline-block;
        vertical-align: -4px;
        background-position: -589px -96px;
        width: 17px;
        height: 17px;
    }
    .header .search .input {
        display: inline-block;
        position: relative;
    }
    .header .search .input .inputRightPart {
        position: absolute;
        right: 0;
        top: -1px;
    }
    h1, h2, h3, h4, h5, h6 {
        margin: 0;
        padding: 0;
        font-size: 100%;
        font-weight: normal;
    }
    .m-filter .list-more .customFilter input {
        width: 35px;
        height: 18px;
        text-align: center;
        border: 1px solid #b7b7b7;
    }
    .m-filter .list-more .customFilter {
        margin-top: 5px;
        float: left;
    }
</style>
<div id="app">
    @include('layouts._header')
    <div class="meny" style="width: 260px; height: 100%; position: fixed; display: block; z-index: 1; transform-origin: 100% 50% 0px; transition: all 0.5s ease 0s; transform: translateX(-100%) translateX(6px) scale(1.01) rotateY(-30deg);">
        @include('layouts._menu')
    </div>
    <div class="contents">
        @yield('content')
    </div>
    @include('layouts._footer')
</div>
<!-- JS 脚本 -->
<script type="text/javascript" src="{{ URL::asset('/realEstate/js/app.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('/realEstate/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('/realEstate/js/jquery.dataTables.bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('/menu/meny.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('/realEstate/js/Chart.min.2.7.1.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('/realEstate/js/comm.js?5') }}"></script>
@yield('script')
</body>
</html>

<script>
    meny = Meny.create({
        // The element that will be animated in from off screen
        menuElement: document.querySelector('.meny'),

        // The contents that gets pushed aside while Meny is active
        contentsElement: document.querySelector('.contents'),

        // [optional] The alignment of the menu (top/right/bottom/left)
        position: Meny.getQuery().p || 'left',

        // [optional] The height of the menu (when using top/bottom position)
        height: 200,

        // [optional] The width of the menu (when using left/right position)
        width: 260,

        // [optional] Distance from mouse (in pixels) when menu should open
        threshold: 40,

        // [optional] Use mouse movement to automatically open/close
        mouse: true,

        // [optional] Use touch swipe events to open/close
        touch: true
    });

    if( Meny.getQuery().u && Meny.getQuery().u.match( /^http/gi ) ) {
        var contents = document.querySelector( '.contents' );
        contents.style.padding = '0px';
        contents.innerHTML = '<div class="cover"></div><iframe src="'+ Meny.getQuery().u +'" style="width: 100%; height: 100%; border: 0;       position: absolute;"></iframe>';
    }
</script>