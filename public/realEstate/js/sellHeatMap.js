sellHeatMap = {
    _heatMapData: {},
    _map: Object,
    _heatmap : Object,
    getSellHeatMap : function ($year) {
        J.ajaxFun({
            url:'/map/ajax/sellHeatMap',
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
    }

};
