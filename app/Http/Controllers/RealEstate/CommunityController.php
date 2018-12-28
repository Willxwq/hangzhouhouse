<?php

namespace App\Http\Controllers\RealEstate;

use App\Models\RealEstate\Community;
use App\Models\RealEstate\RentInfo;
use App\Services\RealEstate\CommunityService;
use App\Services\RealEstate\HouseInfoService;
use App\Services\RealEstate\RegionDictionaryService;
use App\Services\RealEstate\RentInfoService;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Charts\SampleChart;

class CommunityController extends BaseController
{
    /**
     * @param SampleChart $sampleChart
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(SampleChart $sampleChart)
    {
        $sampleChart->labels([])
            ->dataset('test', 'bar', [])->options([
                'borderColor' => '#00c3c1',
                'lineTension' => '0',
                'fill' => false,
                'hitRadius' => 20,
            ]);

        return view('realestate.community', ['chart' => $sampleChart]);
    }

    /**
     * 获取小区详细信息
     * @param $communityName
     * @param CommunityService $communityService
     * @param HouseInfoService $houseInfoService
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function communityDetail($communityName, CommunityService $communityService,
                                    HouseInfoService $houseInfoService, RentInfoService $rentInfoService)
    {
        $result = $communityService::getCommunityDetail($communityName);
        $houseInfo = $houseInfoService::communityDetail($communityName);
        $rentInfo = $rentInfoService::communityDetail($communityName);

        $data = $houseInfo;
        $data['communityInfo'] = $result;
        $data['rentInfo'] = $rentInfo['rentInfo'];

        return view('realestate.communityDetail', ['data' => $data]);
    }

    /**
     * @param $data
     * @return mixed
     */
    public static function conversionData2($data)
    {
        $res['x'] = array_column($data, 'x');
        $res['y'] = array_column($data, 'y');

        return $res;
    }

    /**
     * 获取地区列表
     * @param RegionDictionaryService $regionDictionaryService
     * @param $type
     * @param $districtId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRegionList(RegionDictionaryService $regionDictionaryService, $type, $districtId)
    {
        $list = $regionDictionaryService::getRegionList($type, $districtId);

        return self::format(200, $list);
    }

    /**
     * 获取商圈通过地区
     * @param CommunityService $communityService
     * @param Request $request
     */
    public static function getCommunityDetailByBizcircle(CommunityService $communityService, Request $request)
    {
        $param = $request->post();
        $params = [
            'bizcircle' => $param['bizcircle'],
            'start' => $param['start'],
            'length' => $param['length']
        ];
        $list = $communityService::getCommunityDetailByBizcircle($params);

        return self::formatDate($list);
    }
}
