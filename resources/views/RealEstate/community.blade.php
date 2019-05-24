@extends('layouts/app')

@section('content')
    <div class="">
        <div class="container-fluid">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="index.html">1</a>
                </li>
                <li class="breadcrumb-item active">2</li>
                <li class="breadcrumb-item active">3</li>
            </ol>
            <div class="row">
                <div class="col-12">
                    <div class="col-md-6 offset-md-3">
                        <div id="alert"></div>
                        <div class="card">
                            <div class="card-body">
                                <center>
                                    <h5 for="card-title">{{--获取商圈成交房源详细分析--}}</h5>
                                </center>
                                <div class="input-group">
                                    <input id="bizcircle" type="text" class="form-control" placeholder="{{--请输入商区名称（例如转塘...）--}}">
                                    <span class="input-group-btn"><button class="btn btn-primary" type="button" onclick="getcommunitybybizcircle()">搜索</button></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="col-md-12">
                        <ul class="nav nav-tabs" id="navtabs">
                            {{--<li class="nav-item"><a class="nav-link" href="#">上城</a></li>--}}
                        </ul>
                        <ul class="nav nav-tabs" id="nav">
                            {{--<li class="nav-item"><a class="nav-link" href="#">南星</a></li>--}}
                        </ul>
                    </div>
                    <div id="chart-container" style="height: 450px;">
                        <div class="">
                            <div class="card">
                                <div class="card-body">
                                    {!! $chart->container() !!}
                                </div>
                            </div>
                        </div>
                        {{--{!! $chart->container(); !!}--}}
                        {{--<canvas id="mycanvas"></canvas>--}}
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
    {!! $chart->script()  !!}

    <script>
        $(document).ready(function () {
            region.getRegionList(1, 0);

            $('#navtabs .nav-link').on('click', function ($this) {
                region.getRegionList(2, $(this).attr('data-id'));
            });
            region.bind('');
            region.chartOb = window.{{ $chart->id }};
        });

    </script>
    <script type="text/javascript" src="{{ URL::asset('/realEstate/js/community.js?4') }}"></script>
@endsection