<?php
namespace App\Http\Controllers\House;

use App\Http\Controllers\BaseController;
use App\Models\RealEstate\Community;
use App\Charts\SampleChart;
use App\Models\RealEstate\HisPrice;

class HouseController extends BaseController
{
    public function index()
    {
        return view('house.index', ['data' => '']);
    }

    public function test()
    {
        $community = new Community();
        $sampleChart = new SampleChart();


        //各个区域小区数量
        $res = $this::conversionData($community->numOfCellsInEachRegion());

        $sampleChart->labels($res['x'])
            ->dataset('各区小区数量', 'line', $res['y'])->options([
                'borderColor' => '#00c3c1',
                'lineTension' => '0',
                'fill' => false,
                'hitRadius' => 20,
            ]);

        $sampleChart2 = new SampleChart();

        $res2 = $this::conversionData($community->averagePriceRankingOfEachRegion());

        $sampleChart2->labels($res2['x'])
            ->dataset('各区小区数量', 'bar', $res2['y'])->options([
                'borderColor' => '#00c3c1',
                'lineTension' => '0',
                'fill' => false,
                'hitRadius' => 20,
            ]);
        return view('house.test', [
            'chart' => $sampleChart,
            'chart2' => $sampleChart2
        ]);
    }

    public static function conversionData($data)
    {
        $res['x'] = array_column($data, 'x');
        $res['y'] = array_column($data, 'y');

        return $res;
    }

    public function downcommunity()
    {
        $hisPrice = new HisPrice();
        //$res = $this::conversionData($hisPrice->downcommunity());

        return view('realEstate.test');
    }
}