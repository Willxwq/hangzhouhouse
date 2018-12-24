$(document).ready(function () {
    region.getRegionList(1, 0);

    $('#navtabs .nav-link').on('click', function ($this) {
        region.getRegionList(2, $(this).attr('data-id'));
    });
});

var region = {
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