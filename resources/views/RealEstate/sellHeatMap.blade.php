@extends('layouts/app')
<style>
    html,
    body,
    #container {
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
    }
</style>
@section('content')
<div id="container"></div>
@endsection

@section('script')
    <script src="//webapi.amap.com/maps?v=1.4.15&key=1d6ca55d23197e9af0d01d872fcd563e"></script>
    <script type="text/javascript" src="{{ URL::asset('/realEstate/js/sellHeatMap.js') }}"></script>
    <script>
        $(document).ready(function () {
            var reg = new RegExp("(^|&)year=([^&]*)(&|$)");
            var r = window.location.search.substr(1).match(reg);
            sellHeatMap.getSellHeatMap(unescape(r[2]));

            if (!isSupportCanvas()) {
                alert('热力图仅对支持canvas的浏览器适用,您所使用的浏览器不能使用热力图功能,请换个浏览器试试~')
            }

            //判断浏览区是否支持canvas
            function isSupportCanvas() {
                var elem = document.createElement('canvas');
                return !!(elem.getContext && elem.getContext('2d'));
            }
        });

        //详细的参数,可以查看heatmap.js的文档 http://www.patrick-wied.at/static/heatmapjs/docs.html
        //参数说明如下:
        /* visible 热力图是否显示,默认为true
         * opacity 热力图的透明度,分别对应heatmap.js的minOpacity和maxOpacity
         * radius 势力图的每个点的半径大小
         * gradient  {JSON} 热力图的渐变区间 . gradient如下所示
         *	{
         .2:'rgb(0, 255, 255)',
         .5:'rgb(0, 110, 255)',
         .8:'rgb(100, 0, 255)'
         }
         其中 key 表示插值的位置, 0-1
         value 为颜色值
         */
    </script>
@endsection