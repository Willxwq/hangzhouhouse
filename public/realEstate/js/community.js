$(document).ready(function () {
    region.getRegionList(1, 0);

    $('#navtabs .nav-link').on('click', function ($this) {
        region.getRegionList(2, $(this).attr('data-id'));
    });
});

var region = {
    _dt: {},
    bind : function (bizcircle) {
        region._dt=J.dataTable.bind("example", {
            "sPaginationType": "input",
            ajax: {
                url:'community/getCommunityDetailByBizcircle',
                data:{ bizcircle: bizcircle }
            },
            columns: [
                {title:'产品代码',data:'id', width:'7%'},
                // {title:'品牌',data: "",width:'3%',
                //     render:function(data,type,row,meta) {
                //         return row.brandNameCn + ' ' + row.brandNameEn;
                //     }
                // }
            ],
            columnDefs:[{

            }
            ]
        });
    },
    getRegionList : function (type, districtId) {
        J.ajaxFun({
            url:'getRegionList/' + type + '/' + districtId,
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
            // $html += '<li class="nav-item"><a class="nav-link" href="?bizcircle='+ n.bizcircle + '">'+ n.bizcircle +'</a></li>';
        });
        $('#nav').append($html);

        $('#nav .nav-link').on('click', function ($this) {
            region.getCommunityDetailByBizcircle($(this).text());
        });
    },
    getCommunityDetailByBizcircle : function (bizcircle) {
        var datatable = region.bind(bizcircle);
    }
}