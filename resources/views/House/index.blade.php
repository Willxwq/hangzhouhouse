@extends('layouts/app')

@section('content')

    <div class="row">
        <div class="col-12">
            <div id="alert"></div>
            <div class="jumbotron">
                <div class="container">
                    <h2 class="text-center">{{--杭州二手房数据可视化分析--}}</h2>
                    <h5 class="text-center">{{---旨在提供历史房价和网签数据，帮助用户更好的评估房产和预测未来的走势--}}</h5>
                    <div class="row">
                        <div class="col-md-6 offset-md-3">
                            <div class="input-group">
                                <input type="text" class="form-control autocomplete" id="community"
                                       placeholder="请输入小区名称（例如望京新城...）">
                                <span class="input-group-btn">
                        <button class="btn btn-primary" type="button" onclick="search()">搜索</button>
                      </span>
                            </div>
                        </div>
                    </div>
                    <ul class="nav justify-content-center">
                        <li class="nav-item">
                            <a class="nav-link disabled" href="#">热门搜索:</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="//www.ershoufangdata.com/map.html?community=育新花园">育新花园</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-table fa-fw"></i>最近三日网签数据
                            <div class="pull-right">
                                <a class="btn btn-primary btn-sm" role="button" href="volumn.html">更多</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead id="table-head"></thead>
                                <tbody id="records_table"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-newspaper-o fa-fw"></i>最新资讯
                            <div class="pull-right">
                                <a class="btn btn-primary btn-sm" role="button" href="news.html">更多</a>
                            </div>
                        </div>
                        <div class="card-body" id="news">
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            </br>
            <div class="row">

            </div>
            </br>
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-search fa-fw"></i>数据查询
                </div>

            </div>
            </br>
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-question-circle-o fa-fw"></i>温馨提示
                </div>
                {{--<div class="card-body">
                    <ul>
                        <li>本站成交房源和小区信息来自于<a href="https://bj.lianjia.com/" target="_blank">杭州链家网</a>和<a
                                    href="https://bj.5i5j.com/" target="_blank">杭州我爱我家网</a>官方发布。
                        </li>
                        <li>链家网房源成交数据包含成交日期和真实价格，可以真实反应某段时间内的二手房价格趋势。</li>
                        <li>本站网签数据来自于<a href="http://www.bjjs.gov.cn/" target="_blank">杭州市住房和城乡建设委员会</a>官方发布。</li>
                        <li>所有二手房成交都需要进行网签，所以网签数据具有真实性、权威性特征。可以通过网签K线，了解杭州市二手房成交趋势。</li>
                        <li>在二手房交易过程中，买卖双方签订合同后，卖方需要办理房产解压、买房需要办理资质审核，然后才能进行网签。所以网签相比于合同签订会有20天左右的延迟。</li>
                        <li>住宅销售价格指数数据来源于<a href="http://www.bjstats.gov.cn/tjsj/" target="_blank">杭州市统计局</a>官方发布</li>
                        <li>特别声明：本网站数据仅供参考，如有任何问题，请依官方网站公布为准。</li>
                    </ul>
                    <ul>
                </div>--}}
            </div>
            </br>
        </div>
    </div>
    </div>

@endsection