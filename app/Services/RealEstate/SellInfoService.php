<?php

namespace App\Services\RealEstate;

use App\Charts\SampleChart;
use App\Models\RealEstate\SellInfo;
use App\Services\BaseServices;

class SellInfoService  extends BaseServices
{
    /**
     * 存放小区详细信息
     * @var array
     */
    private static $sellInfo = [];
    /**
     * 存放图表颜色
     * @var array
     */
    private static $color = ['#3390dc', '#37c171', '#6cb2eb', '#ffed4a', '#e3342f', '#6c757c', '#fa84ae', '#8ad293', '#c092c6'];

    /**
     * 获取小区详细
     * @param $communityName
     */
    public static function getSellInfoByCommunity($communityName)
    {
        self::$sellInfo = (new SellInfo())->getSellInfoByCommunity($communityName);
        return;
    }

    /**
     * 获取小区详情页相关图表
     * @param $communityName
     * @return mixed
     */
    public static function communityDetail($communityName)
    {
        self::getSellInfoByCommunity($communityName);
        $result['transactions'] = self::createTransactionsChart();
        $result['historicalAvgPrice'] = self::createHistoricalAvgPriceChart();

        return $result;
    }

    /**
     * 创建 历史成交套数图表
     * @return SampleChart
     */
    private static function createTransactionsChart()
    {
        $sampleChart = new SampleChart();

        $sampleChart->labels(array_column(self::$sellInfo, 'time'))
            ->dataset('test', 'line', array_column(self::$sellInfo, 'count'))->options([
                'borderColor' => '#00c3c1',
                'lineTension' => '0',
                'fill' => true,
                'hitRadius' => 20,
            ]);

        return $sampleChart;
    }

    /**
     * 创建 历史成交套数图表
     * @return SampleChart
     */
    private static function createHistoricalAvgPriceChart()
    {
        $sampleChart = new SampleChart();

        $sampleChart->labels(array_column(self::$sellInfo, 'time'))
            ->dataset('test', 'line', array_column(self::$sellInfo, 'unitPrice'))->options([
                'borderColor' => '#00c3c1',
                'lineTension' => '0',
                'fill' => true,
                'hitRadius' => 20,
            ]);

        return $sampleChart;
    }
}
