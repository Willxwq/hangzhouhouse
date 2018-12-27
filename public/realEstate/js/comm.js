var J = {

    /**
     * ajax的post请求
     * @param args
     * args.url 请求URL
     * args.data 请求参数 /model/controll/action
     * args.type 请求类型 POST|GET 默认POST
     * args.call 回调 函数名|匿名函数
     */
    ajaxFun: function (args) {
        if (!args.url) return false
        var surl = args.url.split('/') // 重写URL
        var request_url = '/' + surl[0] + '/' + surl[1] + '/ajax/' + surl[2]
        var reqType = args.type || 'POST'
        var async = args.async || false

        $.ajax({
            url: args.url,
            type: reqType,
            dataType: 'JSON',
            data: args.data,
            timeout: this.ajax_timeout,
            async: async,
            success: function (o) {
                if (o.code == 705) {
                    return false
                    // J.alert('登陆超时,请重新登录',function () {
                    //     location.reload();
                    // });
                }
                if (typeof (args.call) === 'string') {
                    eval(args.call + '(o)')
                } else {
                    args.call(o)
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                switch (textStatus) {
                    case 'timeout':
                        // alert('您的网络灰常不给力哦~请重新加载~~');
                        break
                }
            }
        })
    },
    /**
     * DATATABLE 列表
     * @param tableName
     * @param args
     *  args.ajax           ajax 参数 url|{}
     *  args.columns        表头
     *  args.buttons        按钮
     *  args.order_columns  指定排序列|'all'
     * @returns {null}
     */
    dataTable:
        {
            dt: {},
            bind: function (tabName, args, opts) {
                if (!tabName || !args) return null

                // 默认配置
                var option = {
                    processing: true,
                    serverSide: true,
                    // scrollX: "100%",          //垂直滚动
                    // scrollY: "600px",         //水平滚动
                    // scrollCollapse: true,     //scrollY打开时的保护参数
                    language: {
                        'infoEmpty': '',
                        'sProcessing': '<div class="table-loading-wrapper"><div class="loading-icon"></div><div class="loading-content">加载中...</div></div>',
                        'sLengthMenu': '每页 _MENU_条',
                        'sZeroRecords': '没有匹配结果',
                        'sInfo': '共 _TOTAL_ 条',
                        'sInfoPostFix': '',
                        'sSearch': '搜索:',
                        'sUrl': '',
                        'sEmptyTable': '没有匹配结果',
                        'sLoadingRecords': '<div class="table-loading-wrapper"><div class="loading-icon"></div><div class="loading-content">加载中...</div></div>',
                        'sInfoThousands': ',',
                        'oPaginate': {
                            'sFirst': '首页',
                            'sPrevious': '上页',
                            'sNext': '下页',
                            'sLast': '末页',
                            'sJump': '跳转'
                        },
                        'oAria': {
                            'sSortAscending': ': 以升序排列此列',
                            'sSortDescending': ': 以降序排列此列'
                        }
                    },
                    // dom: 'rtip',
                    lengthChange: false,
                    searching: false,
                    info: true,
                    autoWidth: false,
                    bSort: false,
                    pageLength: 15,
                    pagingType: 'full_numbers'
                }

                var ajaxParam = {} // ajax参数
                if (typeof args === 'string') {
                    ajaxParam.url = args
                } else {
                    typeof args.ajax === 'string' ? ajaxParam.url = args.ajax : ajaxParam = args.ajax
                    if (args.dom) option['dom'] = args.dom
                    if (args.columns) option['columns'] = args.columns
                    if (args.columnDefs) option['columnDefs'] = args.columnDefs
                    if (args.bSort) option['bSort'] = args.bSort
                    if (args.pageLength) option['pageLength'] = args.pageLength
                    // 开启排序并排除指定列 aoColumnDefs: [0,1,2,3，-1]
                    if (args.aoColumnDefs) {
                        option['bSort'] = true
                        option['aoColumnDefs'] = [{bSortable: false, aTargets: args.aoColumnDefs}]
                    }
                    // 默认排序
                    if (args.order) option['order'] = args.order
                    // 使用插件里的分页
                    if (args.sPaginationType) option['sPaginationType'] = args.sPaginationType
                }
                var surl = ajaxParam.url.split('/')// 重写URL
                ajaxParam.url = '/' + surl[0] + '/ajax/' + surl[1];
                option['ajax'] = ajaxParam
                if (opts) {
                    for (var optName in opts) {
                        option[optName] = opts[optName]
                    }
                }

                if( args.xhrCb && typeof  args.xhrCb === 'function') {
                    this.dt = $('#' + tabName).on('xhr.dt', args.xhrCb).DataTable(option)
                }else {
                    this.dt = $('#' + tabName).DataTable(option)
                }
                return this.dt
            },

            reload: function (args, _dt) {
                if (_dt) this.dt = _dt
                if (args) {
                    this.dt.settings()[0].ajax.data = args
                }
                this.dt.ajax.reload()
            },

            draw: function (args, _dt) {
                if (_dt) this.dt = _dt
                if (args) {
                    this.dt.settings()[0].ajax.data = args
                }
                this.dt.draw(false)
            }
        },
}