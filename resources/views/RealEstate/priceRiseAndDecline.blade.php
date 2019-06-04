@extends('layouts/app')

@section('content')
    <div class="">
        <div class="container-fluid">
            <!-- Breadcrumbs-->
            <h3 style="text-align: center;"></h3>
            <div class="row">
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
    {!! $medianChart->script()  !!}
    {!! $squareChart->script()  !!}

    <script>
        $(document).ready(function () {

        });

    </script>
    <script type="text/javascript" src="{{ URL::asset('/realEstate/js/priceRiseAndDecline.js?112') }}"></script>
@endsection