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
    private static $decoration = [' 毛坯 ', ' 简装 ', ' 精装 ', ' 其他 '];

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
        $labels = [];
        foreach (self::$houseInfo as $value) {
            if (isset($data[$value['housetype']])) {
                $data[$value['decoration']][$value['housetype']]['unitPrice'] += $value['unitPrice'];
                $data[$value['decoration']][$value['housetype']]['num'] += 1;
            } else {
                $data[$value['decoration']][$value['housetype']]['unitPrice'] = $value['unitPrice'];
                $data[$value['decoration']][$value['housetype']]['num'] = 0;
            }
            $data[$value['decoration']][$value['housetype']]['num'] += 1;
        }
        foreach ($data as $dateK => $dateV) {
            foreach ($dateV as $itemK =>  $itemV) {
                $data[$dateK][$itemK] = intval($itemV['unitPrice'] / $itemV['num']);
                $labels[] = $itemK;
            }
        }

        self::elog(array_sort(array_unique($labels)));

        $sampleChart->labels(sort(array_unique($labels)))
            ->dataset(self::$decoration[0], 'bar', array_values($data[self::$decoration[0]]))
            ->options([
                'backgroundColor' => self::$color[0],
            ]);
        $sampleChart
            ->dataset(self::$decoration[1], 'bar', array_values($data[self::$decoration[1]]))
            ->options([
                'backgroundColor' => self::$color[1],
            ]);
        $sampleChart
            ->dataset(self::$decoration[2], 'bar', array_values($data[self::$decoration[2]]))
            ->options([
                'backgroundColor' => self::$color[2],
            ]);
        $sampleChart
            ->dataset(self::$decoration[3], 'bar', array_values($data[self::$decoration[3]]))
            ->options([
                'backgroundColor' => self::$color[3],
            ]);

        return $sampleChart;
    }
}