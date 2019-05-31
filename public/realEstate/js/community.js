var region = {
    _dt: {},
    chartOb: {},
    _labels: [],
    _price: [],
    bind : function (bizcircle) {
        region._dt=J.dataTable.bind("example", {
            "sPaginationType": "input",
            ajax: {
                url:'community/getCommunityDetailByBizcircle',
                data:{ bizcircle: bizcircle }
            },
            columns: [
                {title:'小区名',data:'title', width:'5%',
                    render: function (data, type, row, meta) {
                        if (row.title.length > 6) {
                            region._labels.push(row.title.substring(0,5)+"...");
                        } else {
                            region._labels.push(row.title);
                        }
                        return '<td><a target="_blank" href="/community/communityDetail/'+ row.title +'">' + row.title + '</a></td>';
                    }
                },
                {title:'价格',data:'price', width:'4%',
                    render: function (data, type, row, meta) {
                        row.price === '暂无'? price = 0 : price = row.price;
                        region._price.push(price);
                        return '<td>' + row.price + '</td>';
                    }
                },
                {title:'地铁',data:'tagList', width:'12%'},
                {title:'建成',data:'year', width:'5%'},
                {title:'在售数量',data:'onsale', width:'3%'},
            ]},
            {
                drawCallback: function() {
                    region.resetChar();
                    region.updateChar();
                }
            });
    },
    resetChar : function () {
        region.chartOb.data.labels = [];
        region.chartOb.chart.data.datasets.forEach((dataset)=>{
            dataset.data = [];
        });
    },
    updateChar : function () {
        region.chartOb.data.labels = region._labels;
        region.chartOb.chart.data.datasets.forEach((dataset) => {
            dataset.data = region._price;
        region._price = [];
        });
        region._labels = [];
        region.chartOb.update();
    },
    getRegionList : function (type, districtId, city) {
        J.ajaxFun({
            url:'/community/getRegionList/' + type + '/' + districtId+ '/' + city,
            data:{},
            type:'get',
            call:function(o){
                if (districtId !== 0) {
                    region.showBizcircleList(o);
                } else {
                    region.showDistrictList(o);
                }
            }
        })
    },
    showDistrictList : function (data) {
        $html = '';
        $.each(data, function (i, n) {
            $html += '<li class="nav-item"><a class="nav-link" data-id="'+ n.id +'" href="#">'+ n.district +'</a></li>';
        });
        $('#navtabs').append($html);
    },
    showBizcircleList : function (data) {
        $("#nav").empty();
        $html = '';
        $.each(data, function (i, n) {
            $html += '<li class="nav-item"><a class="nav-link" href="#">'+ n.bizcircle +'</a></li>';
        });
        $('#nav').append($html);

        $('#nav .nav-link').on('click', function ($this) {
            region.getCommunityDetailByBizcircle($(this).text());
        });
    },
    getCommunityDetailByBizcircle : function (bizcircle) {
        J.dataTable.reload({bizcircle:bizcircle});
    }
}