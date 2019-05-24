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
            'time' => is_numeric($param['time']) ? $param['time'] : 1,
            'type' => is_numeric($param['type']) ? $param['type'] : 1
        ];
        $list = $sellInfoService::getSellUpsAndDowns($params);

        return self::formatDate($list);
    }
}
