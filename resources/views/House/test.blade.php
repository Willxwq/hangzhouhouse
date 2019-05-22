@extends('layouts/app')

@section('content')

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-table fa-fw"></i>例子
                    <div class="pull-right">
                        <a class="btn btn-primary btn-sm" role="button" href="">更多</a>
                    </div>
                </div>
                <div class="card-body">
                    {!! $chart->container(); !!}
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-newspaper-o fa-fw"></i>例子
                    <div class="pull-right">
                        <a class="btn btn-primary btn-sm" role="button" href="">更多</a>
                    </div>
                </div>
                <div class="card-body">
                    {!! $chart2->container() !!}
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>

@endsection


@section('script')

    {!! $chart->script()  !!}
    {!! $chart2->script() !!}

    <script>
        console.log(window.{{ $chart->id }});
    </script>

@endsection