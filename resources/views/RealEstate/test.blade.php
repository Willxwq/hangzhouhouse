@extends('layouts/app')

@section('content')

    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="index.html">杭州二手房数据</a>
                </li>
                <li class="breadcrumb-item active">调价记录查询</li>
                <li class="breadcrumb-item active">涨跌情况榜单</li>
            </ol>
            <br>
            <ul class="nav justify-content-center">
                <li class="nav-item">
                    <a class="nav-link disabled" href="downcommunity.html">降价小区榜单</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="downhouse.html">降价房源榜单</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="upcommunity.html">涨价小区榜单</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="uphouse.html">涨价房源榜单</a>
                </li>
            </ul>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-table"></i> <strong>近期前100降价房源最多小区</strong></div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('script')

@endsection