<?php

namespace App\Services\RealEstate;

use App\Charts\SampleChart;
use App\Models\RealEstate\HouseInfo;
use App\Services\BaseServices;

class HouseInfoService extends BaseServices
{
    /**
     * 存放小区详细信息
     * @var array
     */
    private static $houseInfo = [];
    /**
     * 存放图表颜色
     * @var array
     */
    private static $color = ['#3390dc', '#37c171', '#6cb2eb', '#ffed4a', '#e3342f', '#6c757c', '#fa84ae', '#8ad293', '#c092c6'];

    /**
     * 获取小区详细
     * @param $communityName
     */
    public static function getHouseInfoByCommunity($communityName)
    {
        self::$houseInfo = (new HouseInfo())->getHouseInfoByCommunity($communityName);
        return;
    }

    /**
     * 获取小区详情页图表
     * @param $communityName
     * @return mixed
     */
    public static function communityDetail($communityName)
    {
        self::getHouseInfoByCommunity($communityName);
        $result['houseType'] = self::getHouseTypeDoughnutChart();
        $result['onSalePrice'] = self::creatHouseOnSalePriceChart();

        return $result;
    }

    /**
     * 创建 小区详细信息甜甜圈图表
     * @return SampleChart
     */
    public static function getHouseTypeDoughnutChart()
    {
        $sampleChart = new SampleChart();

        $houseType = array_count_values(array_column(self::$houseInfo, 'housetype'));
        $sampleChart->labels(array_keys($houseType))
            ->dataset('小区详细信息', 'doughnut', array_values($houseType))
            ->options([
                'backgroundColor' => self::$color,
            ]);

        return $sampleChart;
    }

    public static function creatHouseOnSalePriceChart()
    {
        $sampleChart = new SampleChart();

        $data = [];
        foreach (self::$houseInfo as $value) {
            if (isset($data[$value['housetype']])) {
                $data[$value['housetype']]['unitPrice'] += $value['unitPrice'];
                $data[$value['housetype']]['num'] += 1;
            } else {
                $data[$value['housetype']]['unitPrice'] = $value['unitPrice'];
                $data[$value['housetype']]['num'] = 0;
            }
            $data[$value['housetype']]['num'] += 1;
        }
        foreach ($data as $dateK => $dateV) {
            $data[$dateK] = intval($dateV['unitPrice'] / $dateV['num']);
        }

        $sampleChart->labels(array_keys($data))
            ->dataset('在售价格信息', 'bar', array_values($data))
            ->options([
                'backgroundColor' => self::$color,
            ]);

        return $sampleChart;
    }
}
