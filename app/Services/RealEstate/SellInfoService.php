<?php

namespace App\Services\RealEstate;

use App\Charts\SampleChart;
use App\Models\RealEstate\SellInfo;
use App\Services\BaseServices;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Redis;

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
    private static $color = ['#3390dc', '#37c171', '#6cb2eb', '#ffed4a', '#e3342f', '#6c757c',
                            '#fa84ae', '#5B5B5B', '#c092c6', '#F08080', '#8ad293', '#FFD700'];

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
     * 涨跌幅
     * @param $params
     * @return array
     */
    public static function priceRiseAndDecline($params)
    {
        $data = Redis::get('city'.$params['city']);
        if (empty($result)) {
            $data =  (new SellInfo())->priceRiseAndDecline($params);
            Redis::set('city'.$params['city'], json_encode($data));
        } else {
            $data = json_decode($data);
        }
        return self::createPriceRiseAndDeclineChart($data);
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
     * 挂牌价&&成交价（议价空间）
     * @param $params
     * @return mixed
     */
    public static function getSellUpsAndDowns($params)
    {
        return self::$sellInfo = (new SellInfo())->getSellUpsAndDowns($params);
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
     * 创建 历史成交均价
     * @return SampleChart
     */
    private static function createHistoricalAvgPriceChart()
    {
        $sampleChart = new SampleChart();

        //$median = collect([['foo' => 10], ['foo' => 10], ['foo' => 20], ['foo' => 40]])->median('foo');
        //$median = collect([1, 1, 2, 4])->median();

        $sampleChart->labels(array_column(self::$sellInfo, 'time'))
            ->dataset('test', 'line', array_column(self::$sellInfo, 'unitPrice'))->options([
                'borderColor' => '#00c3c1',
                'lineTension' => '0',
                'fill' => true,
                'hitRadius' => 20,
            ]);

        return $sampleChart;
    }

    /**
     * 创建 涨跌幅
     * @param $data
     * @return array
     */
    private static function createPriceRiseAndDeclineChart($data)
    {
        $sampleChart = new SampleChart();
        $sampleChartP = new SampleChart();
        $sampleChartM = new SampleChart();
        $monthData = ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'];
        $sampleChartP->labels($monthData);
        $sampleChartM->labels($monthData);
        $sampleChart->labels($monthData);
        $result = [];
        $num = 0;

        foreach ($data as $datum) {
            if (empty($datum->deldate_year)) {
                continue;
            }
            $datumP = [];
            $datumS = [];
            $datumM = [];

            for ($i = 1; $i <= 12; $i++) {
                $p = 'price_' . $i;
                $s = 'square_' . $i;
                $m = 'median_' . $i;
                $datumP[] = floor($datum->$p);
                if (empty($datum->$p)) {
                    $datumS[] = 0;
                } else {
                    $datumM[] = floor((collect( array_unique(explode(',', $datum->$m)) )->median())  * 10000);
                    $datumS[] = floor(( $datum->$p / $datum->$s ) * 10000);
                }
            }

            $sampleChartP
                ->dataset($datum->deldate_year, 'line', $datumP)->options([
                    'borderColor' => self::$color[$num],
                    'lineTension' => '0.4',
                    'fill' => false,
                    'hitRadius' => 20,
                ]);

            $sampleChartM
                ->dataset($datum->deldate_year, 'line', $datumM)->options([
                    'borderColor' => self::$color[$num],
                    'lineTension' => '0.4',
                    'fill' => false,
                    'hitRadius' => 20,
                ]);

            $sampleChart
                ->dataset($datum->deldate_year, 'line', $datumS)->options([
                    'borderColor' => self::$color[$num],
                    'lineTension' => '0.4',
                    'fill' => false,
                    'hitRadius' => 20,
                ]);
            $num++;
        }

        $result['total'] = $sampleChartP;
        $result['median'] = $sampleChartM;
        $result['square'] = $sampleChart;
        return $result;
    }
}
