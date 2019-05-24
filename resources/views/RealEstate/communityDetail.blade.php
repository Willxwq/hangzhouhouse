@extends('layouts/app')

@section('content')
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.html">1</a>
            </li>
            <li class="breadcrumb-item active">2</li>
        </ol>
        <div class="row">
            <div class="col-12">
                <div id="alert"></div>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <h2 class="page-header">信息</h2>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-info-circle fa-fw"></i> 基本信息
                    </div>
                    <div class="card-body card-bodyh">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td style="width: 15%">小区名:</td>
                                        <td id="title">{!! $data['communityInfo']['title']; !!}</td>
                                        <td style="width: 15%">参考均价:</td>
                                        <td id="price">{!! $data['communityInfo']['price']; !!}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 15%">建造时间:</td>
                                        <td id="year">{!! $data['communityInfo']['year']; !!}</td>
                                        <td style="width: 15%">建筑类型:</td>
                                        <td id="housetype">{!! $data['communityInfo']['housetype']; !!}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 15%">物业公司:</td>
                                        <td id="service">{!! $data['communityInfo']['service']; !!}</td>
                                        <td style="width: 15%">开发商:</td>
                                        <td id="company">{!! $data['communityInfo']['company']; !!}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 15%">楼栋总数:</td>
                                        <td id="building_num">{!! $data['communityInfo']['building_num']; !!}</td>
                                        <td style="width: 15%">房屋总数:</td>
                                        <td id="house_num">{!! $data['communityInfo']['house_num']; !!}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 15%">在售房源:</td>
                                        <td id="onsalenum">{!! $data['communityInfo']['onsale']; !!}</td>
                                        <td style="width: 15%">在租房源:</td>
                                        <td id="onrent">{!! $data['communityInfo']['onrent']; !!}</td>
                                    </tr>
                                    <tr>
                                        <td>物业费:</td>
                                        <td colspan="3" id="cost">{!! $data['communityInfo']['cost']; !!}</td>
                                    </tr>
                                    <tr>
                                        <td>行政区:</td>
                                        <td colspan="3" id="district">{!! $data['communityInfo']['district']; !!}</td>
                                    </tr>
                                    <tr>
                                        <td>所在商圈:</td>
                                        <td id="bizcircle">{!! $data['communityInfo']['bizcircle']; !!}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <h2 class="page-header">相关数据</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <i class="fa fa-line-chart fa-fw"></i>历史均价走势
                                <div class="pull-right" id="sell-button"></div>
                            </div>
                            <div class="card-body card-bodyh" id="chart-unitprice">
                                {!! $data['historicalAvgPrice']->container(); !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <i class="fa fa-pie-chart fa-fw"></i>小区详细信息
                                <div class="pull-right" id="detail-button"></div>
                            </div>
                            <div class="card-body card-bodyh" id="chart-detail">
                                {!! $data['houseType']->container(); !!}
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-sm-6 col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <i class="fa fa-line-chart fa-fw"></i>历史成交套数
                                <div class="pull-right" id="count-button"></div>
                            </div>
                            <div class="card-body card-bodyh" id="chart-count">
                                {!! $data['transactions']->container(); !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <i class="fa fa-pie-chart fa-fw"></i>小区涨跌信息
                                <div class="pull-right" id="tiaojia-button"></div>
                            </div>
                            <div class="card-body card-bodyh" id="chart-tiaojia">
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-sm-6 col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <i class="fa fa-bar-chart-o fa-fw"></i>在售价格信息
                                <div class="pull-right" id="house-button"></div>
                            </div>
                            <div class="card-body card-bodyh" id="chart-house">
                                {!! $data['onSalePrice']->container(); !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <i class="fa fa-bar-chart-o fa-fw"></i>租房价格信息
                                <div class="pull-right" id="rent-button"></div>
                            </div>
                            <div class="card-body card-bodyh" id="chart-rent">
                                {!! $data['rentInfo']->container(); !!}
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <h2 class="page-header">周边设施</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2 col-md-2">
                        <div id="map-detail" class="card">
                            <div class="card-header text-white bg-primary o-hidden h-100">
                                <div class="row">
                                    <div class="col-sm-3 col-md-3">
                                        <i class="fa fa-graduation-cap fa-4x"></i>
                                    </div>
                                    <div class="col-sm-9 col-md-9 text-right">
                                        <div class="huge" id="school"></div>
                                        <div>学校</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#school-button">
                                <div class="card-footer">
                                    <span class="pull-left">更多信息</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-2 col-md-2">
                        <div id="map-detail" class="card">
                            <div class="card-header text-white bg-success o-hidden h-100">
                                <div class="row">
                                    <div class="col-sm-3 col-md-3">
                                        <i class="fa fa-hospital-o fa-4x"></i>
                                    </div>
                                    <div class="col-sm-9 col-md-9 text-right">
                                        <div class="huge" id="hospital"></div>
                                        <div>医院</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#hospital-button">
                                <div class="card-footer">
                                    <span class="pull-left">更多信息</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-2 col-md-2">
                        <div id="map-detail" class="card">
                            <div class="card-header text-white bg-info o-hidden h-100">
                                <div class="row">
                                    <div class="col-sm-3 col-md-3">
                                        <i class="fa fa-subway fa-4x"></i>
                                    </div>
                                    <div class="col-sm-9 col-md-9 text-right">
                                        <div class="huge" id="subway"></div>
                                        <div>地铁</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#subway-button">
                                <div class="card-footer">
                                    <span class="pull-left">更多信息</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-2 col-md-2">
                        <div id="map-detail" class="card">
                            <div class="card-header text-white bg-warning o-hidden h-100">
                                <div class="row">
                                    <div class="col-sm-3 col-md-3">
                                        <i class="fa fa-shopping-cart fa-4x"></i>
                                    </div>
                                    <div class="col-sm-9 col-md-9 text-right">
                                        <div class="huge" id="shopping"></div>
                                        <div>购物</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#shopping-button">
                                <div class="card-footer">
                                    <span class="pull-left">更多信息</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-2 col-md-2">
                        <div id="map-detail" class="card">
                            <div class="card-header text-white bg-danger o-hidden h-100">
                                <div class="row">
                                    <div class="col-sm-3 col-md-3">
                                        <i class="fa fa-building-o fa-4x"></i>
                                    </div>
                                    <div class="col-md-3 col-md-9 text-right">
                                        <div class="huge" id="building"></div>
                                        <div>写字楼</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#building-button">
                                <div class="card-footer">
                                    <span class="pull-left">更多信息</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-2 col-md-2">
                        <div id="map-detail" class="card">
                            <div class="card-header text-white bg-secondary o-hidden h-100">
                                <div class="row">
                                    <div class="col-sm-3 col-md-3">
                                        <i class="fa fa-bus fa-4x"></i>
                                    </div>
                                    <div class="col-sm-9 col-md-9 text-right">
                                        <div class="huge" id="bus"></div>
                                        <div>公交</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#bus-button">
                                <div class="card-footer">
                                    <span class="pull-left">更多信息</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <i class="fa fa-map-marker fa-fw"></i>地理位置
                                <div class="pull-right">
                                    <a class="btn btn-primary btn-sm" role="button" onclick="showResource(['中学','小学', '幼儿园'])" id="school-button">学校</a>
                                    <a class="btn btn-success btn-sm" role="button" onclick="showResource('医院')" id="hospital-button">医院</a>
                                    <a class="btn btn-info btn-sm" role="button" onclick="showResource('地铁')" id="subway-button">地铁</a>
                                    <a class="btn btn-warning btn-sm" role="button" onclick="showResource(['商场','超市'])" id="shopping-button">购物</a>
                                    <a class="btn btn-danger btn-sm" role="button" onclick="showResource('写字楼')" id="building-button">写字楼</a>
                                    <a class="btn btn-secondary btn-sm" role="button" onclick="showResource('公交')" id="bus-button">公交</a>
                                </div>
                            </div>
                            <div class="card-body card-bodyh">
                                <div id="allmap"></div>
                                <div id="r-result"></div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <h2 class="page-header">推荐周边小区</h2>
                    </div>
                    <div class="col-sm-12 col-md-12">
                        <div class="card">
                            <div class="card-header">小区列表</div>
                            <table class="table table-striped table-bordered" id="community-list">
                                <tr>
                                    <td>名称</td>
                                    <td>参考均价</td>
                                    <td>建筑年代</td>
                                    <td>在售房源</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    {!! $data['houseType']->script()  !!}
    {!! $data['rentInfo']->script()  !!}
    {!! $data['onSalePrice']->script()  !!}
    {!! $data['transactions']->script()  !!}
    {!! $data['historicalAvgPrice']->script()  !!}

@endsection