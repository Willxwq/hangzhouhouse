sellHeatMap = {
    _heatMapData: {},
    _map: Object,
    _heatmap : Object,
    getSellHeatMap : function ($year) {
        J.ajaxFun({
            url:'/map/ajax/sellMedianHeatMap',
            data:{"year": $year},
            type:'get',
            call:function(o){
                sellHeatMap._heatMapData = o.data;
                sellHeatMap.initialSellHeatMap();
            }
        })
    },
    initialSellHeatMap : function () {
        sellHeatMap._map = new AMap.Map("container", {
            mapStyle: 'amap://styles/e4ddea01a762114892905dbabc6c91b2',
            resizeEnable: true,
            center: [120.153576, 30.287459],
            zoom: 11
        });

        sellHeatMap._map.plugin(["AMap.Heatmap"], function () {
            //初始化heatmap对象
            sellHeatMap._heatmap = new AMap.Heatmap(sellHeatMap._map, {
                radius: 25, //给定半径
                opacity: [0, 0.8]
                /*,
                gradient:{
                    0.5: 'blue',
                    0.65: 'rgb(117,211,248)',
                    0.7: 'rgb(0, 255, 0)',
                    0.9: '#ffea00',
                    1.0: 'red'
                }
                 */
            });
            //设置数据集
            sellHeatMap._heatmap.setDataSet({
                data: sellHeatMap._heatMapData,
                max: 100
            });
        });
    },
    mouseHoverHeatMap : function (heatmapData) {
        var map = new AMap.Map('container', {
            mapStyle: 'amap://styles/twilight',
            zoom: 9,
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
                height: [0, 100000]
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
