sellHeatMap = {
    _heatMapData: {},
    _map: Object,
    _heatmap : Object,
    test : function ($year) {
        J.ajaxFun({
            url:'/map/ajax/sellMedianHeatMapEvent',
            data:{"year": $year},
            type:'get',
            call:function(o){
                sellHeatMap._heatMapData = o.data;
                sellHeatMap.mouseHoverHeatMap(sellHeatMap._heatMapData);
            }
        })
    },
    mouseHoverHeatMap : function (heatmapData) {
        var map = new AMap.Map('container', {
            mapStyle: 'amap://styles/twilight',
            zoom: 11,
            center: [120.153576, 30.287459],
            zooms: [4, 12],
            viewMode: '3D'
        });

        var layer = new Loca.HexagonLayer({
            map: map,
            fitView: true,
            eventSupport: true,
        });

        layer.setData(heatmapData, {
            lnglat: function (obj) {
                var val = obj.value;
                return [val['lng'], val['lat']]
            },
            value: 'count',
            type: 'json'
        });

        layer.setOptions({
            unit: 'meter',
            mode: 'count',
            style: {
                color: ['#ecda9a', '#efc47e', '#f3ad6a', '#f7945d', '#f97b57', '#f66356', '#ee4d5a'],
                radius: 2000,
                opacity: 0.85,
                gap: 300,
                height: [0, 10000]
            }
        });

        layer.on('mousemove', function (ev) {
            updateInfo(ev);
        });

        layer.render();

        function updateInfo(ev) {
            var $val = document.getElementById('val');
            var $idx = document.getElementById('indexes');
            var $num = document.getElementById('indexes-num');
            var $lngLat = document.getElementById('lng-lat');

            $val.innerText = ev.value;
            $idx.innerText = ev.indexes.join(', ');
            $num.innerText = ev.indexes.length;
            $lngLat.innerText = ev.lngLat.valueOf();
        }
    }

};
