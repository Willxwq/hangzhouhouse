@extends('layouts/app')

@section('content')
    <div class="content-wrapper">
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
                    <ul class="nav nav-tabs" id="navtabs">
                        {{--<li class="nav-item"><a class="nav-link" href="#">上城</a></li>--}}
                    </ul>
                    <ul class="nav" id="nav">
                        {{--<li class="nav-item"><a class="nav-link" href="#">南星</a></li>--}}
                    </ul>
                    <div id="chart-container">
                        <canvas id="mycanvas"></canvas>

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
<script type="text/javascript" src="{{ URL::asset('/realEstate/js/community.js?2') }}"></script>
@endsection