<?php

namespace App\Http\Controllers\RealEstate;

use App\Http\Controllers\BaseController;
use App\Services\RealEstate\SellInfoService;
use Illuminate\Http\Request;

/**
 * Class SellController
 * @package App\Http\Controllers\RealEstate
 */
class SellController extends BaseController
{
    public function sellUpsAndDownsIndex()
    {
        return view('RealEstate.sellUpsAndDowns', []);
    }

    /** 售出涨跌
     * @param SellInfoService $sellInfoService
     * @param Request $request
     */
    public static function getSellUpsAndDowns(SellInfoService $sellInfoService, Request $request)
    {
        $param = $request->post();
        $params = [
            'city' => is_numeric($param['city']) ? $param['city'] : 0,
            'start' => is_numeric($param['start']) ? $param['start'] : 0,
            'length' => is_numeric($param['length']) ? $param['length'] : 30,
            'time' => is_numeric($param['time']) ? $param['time'] : 1,
            'showType' => is_numeric($param['showType']) ? $param['showType'] : 1,
            'type' => is_numeric($param['type']) ? $param['type'] : 1
        ];
        $list = $sellInfoService::getSellUpsAndDowns($params);

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
        $str .= "-~小区-~挂牌价格-~成交价格-~平方-~成交时间-~历史调价-~链接\r\n";

        foreach ($data['rows'] as $v) {
            if ($param['type'] == 1) {
                $ups_or_downs = $v->totalPrice - $v->salePrice;
            } else {
                $ups_or_downs = $v->salePrice - $v->totalPrice;
            }
            $arrVal = [
                $v->title, $v->ups_or_downs, $ups_or_downs, $v->community, $v->totalPrice, $v->salePrice, $v->square,
                $v->validdate, $v->his, $v->link
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
}
