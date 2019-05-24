var region = {
    _dt: {},
    chartOb: {},
    _labels: [],
    _totalPrice: [],
    _time: '',
    _type: '',
    _color: '#00a65a',
    bind : function () {
        region._dt=J.dataTable.bind("example", {
            "sPaginationType": "input",
            ajax: {
                url:'sell/getSellUpsAndDowns',
                data:{ time: this._time, type: this._type }
            },
            pageLength: 100,
            columns: [
                {title:'标题',data:'title', width:'5%',
                    render: function (data, type, row, meta) {

                        return '<td><a target="_blank" href="'+ row.link +'">' + row.title + '</a></td>';
                    }
                },
                {title:'<button onclick="region.getSellUpsAndDowns(region._time, 1, \'#00a65a\')" class="btn btn-success">跌幅</button>' +
                    '<button onclick="region.getSellUpsAndDowns(region._time, 2, \'#d73925\')" class="btn btn-danger">涨幅</button>',data:'ups_or_downs', width:'4%',
                    render: function (data, type, row, meta) {
                        return '<td><a style="color: '+ region._color +'; font-size: 20px;">' + row.ups_or_downs + '%</a></td>';
                    }
                },
                {title:'挂牌价格/成交价格',data:'totalPrice', width:'4%',
                    render: function (data, type, row, meta) {
                        return '<td>' + row.totalPrice + '/' + row.salePrice + '</td>';
                    }
                },
                {title:'历史调价',data:'link', width:'6%',
                    render: function (data, type, row, meta) {
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
    getSellUpsAndDowns : function (time, type, color) {
        region._color = color;
        region._time = time;
        region._type = type;
        J.dataTable.reload({time:time, type:type});
    }
}