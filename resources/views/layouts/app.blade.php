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