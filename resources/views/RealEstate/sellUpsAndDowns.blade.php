@extends('layouts/app')

@section('content')
    <div class="">
        <div class="container-fluid">
            <!-- Breadcrumbs-->
            <h3 style="text-align: center;"></h3>
            <div class="row">
                    <div class="col-12">
                        <div class="header">
                            <div class="menu"></div>
                            <div class="search">
                                <div class="input" log-mod="search">
                                    <input type="text" name="communityName" id="communityName" value="" autocomplete="off" placeholder="请输入小区名开始找房">
                                    <div class="inputRightPart">
                                        <button class="btn btn-primary" style="width: 50px; height: 45px;" type="button" onclick="region.getSearchParams()">搜索</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="m-filter">
                            <div class="position">
                                <dl>
                                    <h2><dt title="">位置</dt></h2>
                                </dl>
                                <dl>
                                    <dt></dt>
                                    <dd>
                                        <ul class="nav nav-tabs" id="navtabs">
                                            {{--<li class="nav-item"><a class="nav-link" href="#">上城</a></li>--}}
                                        </ul>
                                        <ul class="nav nav-tabs" id="nav">
                                            {{--<li class="nav-item"><a class="nav-link" href="#">南星</a></li>--}}
                                        </ul>
                                    </dd>
                                </dl>
                            </div>
                            <div class="list-more">
                                <dl style="height: auto;">
                                    <h2><dt title="">其他</dt></h2>
                                    <dd>
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
                                        <div class="col-lg-2">
                                            <select class="form-control" name="" id="time">
                                                <option value="1">最近一个月</option>
                                                <option value="3">最近3个月</option>
                                                <option value="6">半年</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-2">
                                            <select class="form-control" name="" id="showType">
                                                <option value="1">百分百</option>
                                                <option value="2">数值</option>
                                            </select>
                                        </div>
                                    </dd>
                                </dl>
                                <dl style="height: auto;">
                                    <h2><dt title="">成交价</dt></h2>
                                    <dd>
                                        <span class="customFilter mt" data-role="area">
                                            <input name="minTotalPrice" type="text" role="minValue" value="">
                                            <span>-</span>
                                            <input name="maxTotalPrice" type="text" role="maxValue" value="">&nbsp;<span>万</span>
                                          </span>
                                    </dd>
                                </dl>
                                <dl style="height: auto;">
                                    <h2><dt title="">面积</dt></h2>
                                    <dd>
                                        <span class="customFilter mt" data-role="area">
                                            <input name="minSquare" type="text" role="minValue" value="">
                                            <span>-</span>
                                            <input name="maxSquare" type="text" role="maxValue" value="">&nbsp;<span>平</span>
                                          </span>
                                    </dd>
                                </dl>
                                <dl style="height: auto;">
                                    <h2><dt title="">平方价</dt></h2>
                                    <dd>
                                        <span class="customFilter mt" data-role="area">
                                            <input name="minUnitPrice" type="text" role="minValue" value="">
                                            <span>-</span>
                                            <input name="maxUnitPrice" type="text" role="maxValue" value="">&nbsp;<span>万/平</span>
                                          </span>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                        <br>
                        <div class="col-md-12">

                        </div>
                        <br>
                        <div class="table-responsive">
                            <table id="example" style="width: 100%"></table>
                            {{--<table class="table table-striped" id="dataTable" width="100%" cellspacing="0">--}}
                            {{--</table>--}}
                        </div>
                    </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

    <script>
        $(document).ready(function () {
            region.bind('');
            region.getRegionList(1, 0, 0);

            $('#navtabs .nav-link').on('click', function ($this) {
                region.getRegionList(2, $(this).attr('data-id'), 0);
            });
            $('#time').change(function(){
                region._time = $('#time').val();
                region.getSellUpsAndDowns();
            });
            $('#showType').change(function(){
                region._showType = $('#showType').val();
                region.getSellUpsAndDowns();
            });
            $('#city').change(function(){
                region._city = $('#city').val();
                region.getSellUpsAndDowns();
            });
        });

    </script>
    <script type="text/javascript" src="{{ URL::asset('/realEstate/js/sellUpsAndDowns.js?112') }}"></script>
@endsection