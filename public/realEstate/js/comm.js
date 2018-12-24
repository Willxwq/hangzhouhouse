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
}