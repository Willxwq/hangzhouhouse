<?php

namespace App\Http\Controllers\RealEstate;

use App\Http\Controllers\BaseController;
use App\Services\RealEstate\CommunityService;
use App\Services\RealEstate\DeepLearnService;
use App\Services\RealEstate\SellInfoService;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Boolean;

/**
 * Class SellController
 * @package App\Http\Controllers\RealEstate
 */
class SellController extends BaseController
{
    /**
     * 挂牌价&&成交价（议价空间）视图
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function sellUpsAndDownsIndex()
    {
        return view('RealEstate.sellUpsAndDowns', []);
    }

    /**
     * 创建 涨跌幅
     * @param SellInfoService $sellInfoService
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function priceRiseAndDeclineIndex(SellInfoService $sellInfoService, Request $request)
    {
        $params = $request->post();
        $params['city'] = empty($params['city']) ? 0 : $params['city'];
        $result = $sellInfoService::priceRiseAndDecline($params);

        return view('RealEstate.priceRiseAndDecline', ['totalChart' => $result['total'],
            'squareChart' => $result['square'], 'medianChart' => $result['median'], 'sellCountChart' => $result['sellCount']]);
    }

    /** 挂牌价&&成交价（议价空间）
     * @param SellInfoService $sellInfoService
     * @param Request $request
     */
    public static function getSellUpsAndDowns(SellInfoService $sellInfoService, Request $request)
    {
        $param = $request->post();
        //$params = [
        //    'city' => is_numeric($param['city']) ? $param['city'] : 0,
        //    'bizcircle' => $param['bizcircle'],
        //    'community' => $param['community'],
        //    'start' => is_numeric($param['start']) ? $param['start'] : 0,
        //    'length' => is_numeric($param['length']) ? $param['length'] : 30,
        //    'time' => is_numeric($param['time']) ? $param['time'] : 1,
        //    'showType' => is_numeric($param['showType']) ? $param['showType'] : 1,
        //    'type' => is_numeric($param['type']) ? $param['type'] : 1
        //];
        $list = $sellInfoService::getSellUpsAndDowns($param);

        return self::formatDate($list);
    }

    /**
     * 导出csv
     * @param SellInfoService $sellInfoService
     * @param Request $request
     */
    public function exportCsv(SellInfoService $sellInfoService, Request $request)
    {
        $str = "标题";

        $param = $request->post();
        $params = [
            'city' => is_numeric($param['city']) ? $param['city'] : 0,
            'start' => 0,
            'isExport' => 1,
            'time' => is_numeric($param['time']) ? $param['time'] : 1,
            'showType' => 1,
            'length' => 30,
            'type' => is_numeric($param['type']) ? $param['type'] : 1
        ];
        $data = (array)$sellInfoService::getSellUpsAndDowns($params);

        if ($param['type'] == 1) {
            $str .= '-~跌(百分比)-~跌(数值)';
        } else {
            $str .= '-~涨(百分比)-~涨(数值)';
        }
        $str .= "-~小区-~挂牌价格-~成交价格-~平方-~成交周期-~成交时间-~历史调价-~链接\r\n";

        foreach ($data['rows'] as $v) {
            if ($param['type'] == 1) {
                $ups_or_downs = $v->totalPrice - $v->salePrice;
            } else {
                $ups_or_downs = $v->salePrice - $v->totalPrice;
            }
            $arrVal = [
                $v->title, $v->ups_or_downs, $ups_or_downs, $v->community, $v->totalPrice, $v->salePrice, $v->square,
                $v->cycle, $v->dealdate, $v->his, $v->link
            ];
            $str .= implode('-~', $arrVal);
            $str .= "\r\n";
        }
        $str = str_replace(',', ';', $str);
        $str = str_replace('-~', ',', $str);
        $new_name = self::create_uuid() . '.csv';

        header("Content-type:text/csv;");
        header("Content-Disposition:attachment;filename=" . $new_name);
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');
        echo $str;
    }

    public function sellHeatMapIndex(){return view('RealEstate.sellHeatMap');}

    public function sellMedianHeatMapIndex(){return view('RealEstate.sellMedianHeatMap');}

    public function sellMedianHeatMapEventIndex(){return view('RealEstate.sellMedianHeatMapEvent');}

    public function sellHeatMap(SellInfoService $sellInfoService, Request $request)
    {
        set_time_limit(0);
        //$year = $request->post();
        //$list = $sellInfoService::sellHeatMap($year['year']);

        (new DeepLearnService())->test();
        return self::formatDate(['rows' => null]);
        //return self::formatDate(['rows' => $list]);
    }

    public function sellMedianHeatMap(SellInfoService $sellInfoService, Request $request)
    {
        $year = $request->post();
        $list = $sellInfoService::sellMedianHeatMap($year['year']);

        return self::formatDate(['rows' => $list]);
    }

    public function sellMedianHeatMapEvent(SellInfoService $sellInfoService, Request $request)
    {
        $year = $request->post();
        $list = $sellInfoService::sellMedianHeatMapEvent($year['year']);

        return self::formatDate(['rows' => $list]);
    }

    public function coverHeatMap()
    {
        $service = new CommunityService;
        $url = "https://restapi.amap.com/v3/geocode/geo";

        $data = $service::getAllCommunity();
        $param = [
            "key" => "1d6ca55d23197e9af0d01d872fcd563e",
            "city" => 330100,
            "batch" => "true",
            "output" => "JSON"
        ];
        $count = count($data);

        $num = 0;
        $aa = 0;
        $ids = [];
        $coverData = [];
        foreach ($data as $datum) {
            $num++;
            $param['address'] .= $datum['title']."|";
            $ids[] = $datum['id'];
            if ($num == 10) {
                $param['address'] = rtrim($param['address'], "|");
                $result =  self::requestApi($url, $param, "get");
                if (empty($result['geocodes'])) {
                    continue;
                }
                for ($i = 0; $i < count($result['geocodes']); $i++) {
                    if (!empty($result['geocodes'][$i]["location"])) {
                        $lngAndLat = explode(",", $result['geocodes'][$i]["location"]);
                        $coverData[] = ['id' => $ids[$i], "lng" => $lngAndLat[0], "lat" => $lngAndLat[1]];
                    }
                }
                if (!empty($coverData)) {
                    $aa += count($coverData);
                }
                self::elog("总数：".$count." 完成：".$aa);
                $service::saveLngAndLat($coverData);
                $param['address'] = "";
                unset($ids);
                unset($coverData);
                $num = 0;
            }
        }

        return true;
    }
}
