<?php

namespace App\Http\Controllers\RealEstate;

use App\Models\RealEstate\Community;
use App\Services\RealEstate\RegionDictionaryService;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Charts\SampleChart;

class CommunityController extends BaseController
{
    public function index(SampleChart $sampleChart)
    {
        $sampleChart->labels([])
            ->dataset('test', 'line', [])->options([
                'borderColor' => '#00c3c1',
                'lineTension' => '0',
                'fill' => false,
                'hitRadius' => 20,
            ]);

        return view('realestate.community', ['chart' => $sampleChart]);
    }

    public static function conversionData2($data)
    {
        $res['x'] = array_column($data, 'x');
        $res['y'] = array_column($data, 'y');

        return $res;
    }

    public function getRegionList(RegionDictionaryService $regionDictionaryService, $type, $districtId)
    {
        $list = $regionDictionaryService::getRegionList($type, $districtId);

        return self::format(200, $list);
    }

    public static function getCommunityDetailByBizcircle(RegionDictionaryService $regionDictionaryService, Request $request, SampleChart $sampleChart)
    {
        $param = $request->post();
        $params = [
            'bizcircle' => $param['bizcircle'],
            'start' => $param['start'],
            'length' => $param['length']
        ];
        $list = $regionDictionaryService::getCommunityDetailByBizcircle($params);

        $res = self::conversionData(array_column($list['rows'], 'title'), array_column($list['rows'], 'price'));
        $sampleChart->labels($res['x'])
            ->dataset('test', 'line', $res['y'])->options([
                'borderColor' => '#00c3c1',
                'lineTension' => '0',
                'fill' => false,
                'hitRadius' => 20,
            ]);

        $list['chart'] = $sampleChart->api();
        return self::formatDate($list);
    }
}
