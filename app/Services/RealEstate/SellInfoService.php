<?php

namespace App\Services\RealEstate;

use App\Charts\SampleChart;
use App\Models\RealEstate\SellInfo;
use App\Services\BaseServices;
use Illuminate\Support\Facades\Cache;
use PhpParser\Node\Expr\Array_;

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
    private static $color = ['#3390dc', '#fa84ae', '#6cb2eb', '#6c757c', '#F08080', '#ffed4a',
                            '#37c171', '#e3342f', '#8ad293', '#5B5B5B', '#c092c6', '#FFD700'];

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
        $redis = Cache::store('redis');
        $data = $redis->get('city'.$params['city']);
        if (empty($data)) {
            $data =  (new SellInfo())->priceRiseAndDecline($params);
            $redis->put('city'.$params['city'], json_encode($data), 1440);
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
     * 获取当前月的热力图经纬度数据
     * @param $year
     * @return array
     */
    public static function sellHeatMap($year)
    {
        switch ($year) {
            case 2019:
                $timeArr = ["2019-01-01", "2020-01-01"];
            case 2018:
                $timeArr = ["2018-01-01", "2019-01-01"];
            case 2017:
                $timeArr = ["2017-01-01", "2018-01-01"];
        }
        $redis = Cache::store('redis');
        $redisData = $redis->get('sellHeatMap-' . $year);
        if (empty($redisData)) {
            $data = (new SellInfo())->getMonthSell($timeArr);
            $result = [];
            foreach ($data as $item) {
                if (empty($item["lng"])) {
                    continue;
                }
                if (empty($result[$item['id']])) {
                    $result[$item['id']] = [
                        "lng" => (float) $item["lng"],
                        "lat" => (float) $item["lat"],
                        "count" => 1
                    ];
                } else {
                    $result[$item['id']]['count']+=1;
                }
            }
            if ($year != 2019) {
                $redis->put('sellHeatMap-' . $year, json_encode($result), 99999);
            }
        } else {
            $result = (array)json_decode($redisData);
        }
        return array_values($result);
    }

    /**
     * 获取当前月的热力图经纬度和中位平方价数据
     * @param $year
     * @return array
     */
    public static function sellMedianHeatMap($year)
    {
        switch ($year) {
            case 2019:
                $timeArr = ["2019-01-01", "2020-01-01"];
            case 2018:
                $timeArr = ["2018-01-01", "2019-01-01"];
            case 2017:
                $timeArr = ["2017-01-01", "2018-01-01"];
        }
        $redis = Cache::store('redis');
        $redisData = $redis->get('sellMedianHeatMap-1000-' . $year);
        if (empty($redisData)) {
            $data = (new SellInfo())->getMonthSell($timeArr);
            $result = [];
            foreach ($data as $item) {
                if (empty($item["lng"])) {
                    continue;
                }
                if (empty($result[$item['id']])) {
                    $result[$item['id']] = [
                        "lng" => (float) $item["lng"],
                        "lat" => (float) $item["lat"],
                        "medianPrice" => [(float)$item['unitPrice']]
                    ];
                } else {
                    $result[$item['id']]['medianPrice'][] = (float)$item['unitPrice'];
                }
            }

            foreach ($result as &$value) {
                $value["count"] = collect( array_unique($value['medianPrice']) )->median() / 1000;
            }
            if ($year != 2019) {
                $redis->put('sellMedianHeatMap-1000-' . $year, json_encode($result), 99999);
            }
        } else {
            $result = (array)json_decode($redisData);
        }
        return array_values($result);
    }

    /**
     * 获取当前月的热力图经纬度和中位平方价数据
     * 鼠标事件
     * @param $year
     * @return array
     */
    public static function sellMedianHeatMapEvent($year)
    {
        switch ($year) {
            case 2019:
                $timeArr = ["2019-01-01", "2020-01-01"];
            case 2018:
                $timeArr = ["2018-01-01", "2019-01-01"];
            case 2017:
                $timeArr = ["2017-01-01", "2018-01-01"];
        }
        $redis = Cache::store('redis');
        $redisData = $redis->get('sellMedianHeatMap-' . $year);
        if (empty($redisData)) {
            $data = (new SellInfo())->getMonthSell($timeArr);
            $result = [];
            foreach ($data as $item) {
                if (empty($item["lng"])) {
                    continue;
                }
                if (empty($result[$item['id']])) {
                    $result[$item['id']] = [
                        "lng" => (float) $item["lng"],
                        "lat" => (float) $item["lat"],
                        "medianPrice" => [(float)$item['unitPrice']]
                    ];
                } else {
                    $result[$item['id']]['medianPrice'][] = (float)$item['unitPrice'];
                }
            }

            foreach ($result as &$value) {
                $value["count"] = collect( array_unique($value['medianPrice']) )->median();
            }
            if ($year != 2019) {
                $redis->put('sellMedianHeatMap-' . $year, json_encode($result), 99999);
            }
        } else {
            $result = (array)json_decode($redisData);
        }
        return array_values($result);
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
        $sampleChartC = new SampleChart();
        $sampleChartP = new SampleChart();
        $sampleChartM = new SampleChart();
        $monthData = ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'];
        $sampleChartC->labels($monthData);
        $sampleChartP->labels($monthData);
        $sampleChartM->labels($monthData);
        $sampleChart->labels($monthData);
        $result = [];
        $num = 0;
        $tempData = [];

        foreach ($data as $datum) {
            if (empty($datum->year)) {
                continue;
            }

            $tempData[$datum->year][$datum->month] = $datum;
        }

        foreach ($tempData as $tempKey => $tempDatum) {
            $datumC = [];
            $datumP = [];
            $datumS = [];
            $datumM = [];
            foreach ($tempDatum as $item) {
                $datumP[] = floor($item->totalPrice);
                if (empty($item->totalPrice)) {
                    $datumS[] = 0;
                } else {
                    $datumC[] = $item->sellCount;
                    $datumM[] = collect( array_unique(explode(',', $item->unitPrice)) )->median();
                    $datumS[] = floor(( $item->totalPrice / $item->square ) * 10000);
                }
            }

            $sampleChartC
                ->dataset($tempKey, 'line', $datumC)->options([
                    'borderColor' => self::$color[$num],
                    'lineTension' => '0.4',
                    'fill' => false,
                    'hitRadius' => 20,
                ]);

            $sampleChartP
                ->dataset($tempKey, 'line', $datumP)->options([
                    'borderColor' => self::$color[$num],
                    'lineTension' => '0.4',
                    'fill' => false,
                    'hitRadius' => 20,
                ]);

            $sampleChartM
                ->dataset($tempKey, 'line', $datumM)->options([
                    'borderColor' => self::$color[$num],
                    'lineTension' => '0.4',
                    'fill' => false,
                    'hitRadius' => 20,
                ]);

            $sampleChart
                ->dataset($tempKey, 'line', $datumS)->options([
                    'borderColor' => self::$color[$num],
                    'lineTension' => '0.4',
                    'fill' => false,
                    'hitRadius' => 20,
                ]);
            $num++;
        }

        $result['total'] = $sampleChartP;
        $result['sellCount'] = $sampleChartC;
        $result['median'] = $sampleChartM;
        $result['square'] = $sampleChart;
        return $result;
    }
}
