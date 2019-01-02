<?php

namespace App\Services\RealEstate;

use App\Charts\SampleChart;
use App\Models\RealEstate\RentInfo;
use App\Services\BaseServices;

class RentInfoService extends BaseServices
{
    /**
     * 存放小区详细信息
     * @var array
     */
    private static $rentInfo = [];
    /**
     * 存放图表颜色
     * @var array
     */
    private static $color = ['#3390dc', '#37c171', '#6cb2eb', '#ffed4a', '#e3342f', '#6c757c', '#fa84ae', '#8ad293', '#c092c6'];

    /**
     * 获取小区租房信息
     * @param $communityName
     */
    public static function getRentInfoByCommunity($communityName)
    {
        self::$rentInfo = (new RentInfo())->getRentInfoByCommunity($communityName);
        return;
    }

    /**
     * 获取小区租房图表
     * @param $communityName
     * @return mixed
     */
    public static function communityDetail($communityName)
    {
        self::getRentInfoByCommunity($communityName);
        $result['rentInfo'] = self::creatRentPriceChart();

        return $result;
    }

    public static function creatRentPriceChart()
    {
        $sampleChart = new SampleChart();

        $data = [];
        foreach (self::$rentInfo as $value) {
            if (isset($data[$value['zone']])) {
                $data[$value['zone']]['price'] += $value['price'];
                $data[$value['zone']]['num'] += 1;
            } else {
                $data[$value['zone']]['price'] = $value['price'];
                $data[$value['zone']]['num'] = 0;
            }
            $data[$value['zone']]['num'] += 1;
        }
        foreach ($data as $dateK => $dateV) {
            $data[$dateK] = $dateV['price'] / $dateV['num'];
        }

        $sampleChart->labels(array_keys($data))
            ->dataset('租房价格信息', 'bar', array_values($data))
            ->options([
                'backgroundColor' => self::$color,
            ]);

        return $sampleChart;
    }
}
