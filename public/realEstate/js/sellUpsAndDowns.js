var region = {
    _dt: {},
    chartOb: {},
    _labels: [],
    _totalPrice: [],
    _param: {},
    _time: 1,
    _type: 1,
    _city: 0,
    _color: '#00a65a',
    _bizcircle: '',
    _community: '',
    _showType: "1",
    bind : function () {
        region._dt=J.dataTable.bind("example", {
            "sPaginationType": "input",
            ajax: {
                url:'sell/getSellUpsAndDowns',
                data:{ time: this._time, type: this._type, showType: this._showType, city: this._city }
            },
            pagination: true, // 设置为true会在底部显示分页条
            pageLength: 100,
            columns: [
                {title:'标题',data:'title', width:'5%',
                    render: function (data, type, row, meta) {

                        return '<td><a target="_blank" href="'+ row.link +'">' + row.title + '</a></td>';
                    }
                },
                {title:'<button onclick="region.setColor(\'#00a65a\', \'1\')" class="btn btn-success">低于挂牌价</button>' +
                    '<button onclick="region.setColor(\'#d73925\', \'2\')" class="btn btn-danger">高于挂牌价</button>',data:'ups_or_downs', width:'4%',
                    render: function (data, type, row, meta) {
                        if (region._showType === "1") {
                            return '<td><a style="color: '+ region._color +'; font-size: 20px;">' + row.ups_or_downs + '%</a></td>';
                        } else {
                            return '<td><a style="color: '+ region._color +'; font-size: 20px;">' + row.ups_or_downs + '</a></td>';
                        }
                    }
                },
                {title:'挂牌价格/成交价格',data:'totalPrice', width:'4%',
                    render: function (data, type, row, meta) {
                        return '<td>' + row.totalPrice + '/' + row.salePrice + '</td>';
                    }
                },
                {title:'成交周期（天）',data:'cycle', width:'6%',
                    render: function (data, type, row, meta) {
                        return '<td>' + row.cycle + '</td>';
                    }
                },
                {title:'历史调价',data:'his', width:'6%',
                    render: function (data, type, row, meta) {
                            if (row.his === null) {
                                return '<td>暂无</td>';
                            }
                            return '<td>' + row.his + '</td>';
                    }
                },
                {title:'成交时间',data:'dealdate', width:'3%'}
            ]},
            {
                drawCallback: function() {

                },
                fnRowCallback : function(nRow, aData, iDisplayIndex) {

                    // $('th:eq(0)', nRow).attr('style', 'text-align: left; color: red');
                    // $('th:eq(0)', nRow).css('padding-left','10px');
                }
            }
        );
        // J.dataTable.Columns["跌幅"].ColumnName="增幅";
    },
    setColor : function (color, showType) {
        region._color = color;
        region._type = showType;
        this.getSellUpsAndDowns();
    },
    exportCsv : function () {
        document.location.href = "/sell/ajax/exportCsv?type="+region._type+"&time="+region._time+"&city="+region._city;
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
        region._bizcircle = bizcircle;
        region._community = $("#communityName").val();
        this.getSellUpsAndDowns();
    },
    getSearchParams : function () {
        var inputs = $("input");
        inputs.each(function(){
            region._param[this.name] = this.value;
        });
        region.getSellUpsAndDowns();
    },
    getSellUpsAndDowns : function () {
        // params = {time:region._time, type:region._type, showType:region._showType,
        //     city:region._city, bizcircle:region._bizcircle, community:region._community};
        region._param["time"] = region._time;
        region._param["type"] = region._type;
        region._param["showType"] = region._showType;
        region._param["city"] = region._city;
        region._param["bizcircle"] = region._bizcircle;
        J.dataTable.reload(region._param);
    },
}