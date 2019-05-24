@extends('layouts/app')

@section('content')
    <div class="">
        <div class="container-fluid">
            <!-- Breadcrumbs-->
            <h3 style="text-align: center;">涨跌前100</h3>
            <div class="row">
                <div class="col-12">
                    <br>
                    <div class="col-md-12">
                        <div class="col-lg-2 pull-right">
                            <select class="form-control" name="" id="time">
                                <option value="1">最近一个月</option>
                                <option value="3">最近3个月</option>
                                <option value="6">半年</option>
                            </select>
                        </div>
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

            $('#time').change(function(){
                region.getSellUpsAndDowns($('#time').val(), 1, "#00a65a");
            });
        });

    </script>
    <script type="text/javascript" src="{{ URL::asset('/realEstate/js/sellUpsAndDowns.js?12') }}"></script>
@endsection