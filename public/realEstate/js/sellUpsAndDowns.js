var region = {
    _dt: {},
    chartOb: {},
    _labels: [],
    _totalPrice: [],
    _time: '',
    _type: '',
    _city: '',
    _color: '#00a65a',
    _showType: 1,
    bind : function () {
        region._dt=J.dataTable.bind("example", {
            "sPaginationType": "input",
            ajax: {
                url:'sell/getSellUpsAndDowns',
                data:{ time: this._time, type: this._type, showType: this._showType }
            },
            pageLength: 10,
            columns: [
                {title:'标题',data:'title', width:'5%',
                    render: function (data, type, row, meta) {

                        return '<td><a target="_blank" href="'+ row.link +'">' + row.title + '</a></td>';
                    }
                },
                {title:'<button onclick="region.getSellUpsAndDowns(region._time, 1, \'#00a65a\', region._showType)" class="btn btn-success">跌幅</button>' +
                    '<button onclick="region.getSellUpsAndDowns(region._time, 2, \'#d73925\', region._showType)" class="btn btn-danger">涨幅</button>',data:'ups_or_downs', width:'4%',
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
    getSellUpsAndDowns : function (time, type, color, showType, city) {
        region._showType = showType;
        region._color = color;
        region._time = time;
        region._type = type;
        region._city = city;
        J.dataTable.reload({time:time, type:type, showType:showType, city:city});
    },
    exportCsv : function () {
        document.location.href = "/sell/ajax/exportCsv?type="+region._type+"&time="+region._time+"&city="+region._city;
    }
}