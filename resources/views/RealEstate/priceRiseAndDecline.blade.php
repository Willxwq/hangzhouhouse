@extends('layouts/app')

@section('content')
    <div class="">
        <div class="container-fluid">
            <!-- Breadcrumbs-->
            <h3 style="text-align: center;"></h3>
            <div class="row">
                <div class="col-lg-2">
                    <select class="form-control" name="" id="city">
                        <option value="0">杭州</option>
                        <option value="1">上海</option>
                        <option value="2">广州</option>
                        <option value="3">重庆</option>
                        <option value="4">成都</option>
                        <option value="5">深圳</option>
                        <option value="6">合肥</option>
                    </select>
                </div>
                <div class="col-12">
                    <div id="chart-container" style="padding-bottom: 20px;">
                        <div class="">
                            <div class="card">
                                <div class="card-body card-bodyh">
                                    <h2 style="text-align: center;font-size: 24px;">成交量</h2>
                                    {!! $totalChart->container() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div id="chart-container" style="padding-bottom: 20px;">
                        <div class="">
                            <div class="card">
                                <div class="card-body card-bodyh">
                                    <h2 style="text-align: center;font-size: 24px;">成交套数</h2>
                                    {!! $sellCountChart->container() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div id="chart-container" style="padding-bottom: 20px;">
                        <div class="">
                            <div class="card">
                                <div class="card-body card-bodyh">
                                    <h2 style="text-align: center;font-size: 24px;">中位价</h2>
                                    {!! $medianChart->container() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div id="chart-container" style="padding-bottom: 20px;">
                        <div class="">
                            <div class="card">
                                <div class="card-body card-bodyh">
                                    <h2 style="text-align: center;font-size: 24px;">平均价格</h2>
                                    {!! $squareChart->container() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    {!! $totalChart->script()  !!}
    {!! $sellCountChart->script()  !!}
    {!! $medianChart->script()  !!}
    {!! $squareChart->script()  !!}

    <script>
        $(document).ready(function () {
            function getUrlParam(name) {
                var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
                var r = window.location.search.substr(1).match(reg);  //匹配目标参数
                if (r != null) return encodeURI(r[2]); return null; //返回参数值
            }

            $("#city").val(getUrlParam('city'));

            $('#city').change(function(){
                document.location.href = "/sell/priceRiseAndDecline?city=" + $('#city').val();
            });
        });

    </script>
    <script type="text/javascript" src="{{ URL::asset('/realEstate/js/priceRiseAndDecline.js?112') }}"></script>
@endsection